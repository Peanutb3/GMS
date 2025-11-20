<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grievance;
use App\Models\Student;
use App\Traits\CreatesNotifications;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\AuditLog;
use App\Models\GrievanceHistory;

class GrievanceController extends Controller
{
    use CreatesNotifications;
    // public function index()
    // {
    //     $grievances = Grievance::orderByDesc('created_at')->get();
    //     return view('staff.grievances', compact('grievances'));
    // }

    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user->role === 'staff' && $user->staff) {
            $tab = $request->query('tab', 'active');
            $query = Grievance::where('filed_by_staff_id', $user->staff->id);

            // Search by name, program, or case ID
            if ($request->filled('search')) {
                $search = $request->input('search');
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                    ->orWhere('program', 'like', "%{$search}%")
                    ->orWhere('case_id', 'like', "%{$search}%");
                });
            }

            $historyItems = collect();
            if ($tab === 'history') {
                // Build history list: resolved items + deleted snapshots performed by this staff
                $resolvedQ = Grievance::where('filed_by_staff_id', $user->staff->id)
                    ->where('status', 'resolved');
                if ($request->filled('search')) {
                    $search = $request->input('search');
                    $resolvedQ->where(function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                          ->orWhere('program', 'like', "%{$search}%")
                          ->orWhere('case_id', 'like', "%{$search}%")
                          ->orWhere('grievance', 'like', "%{$search}%");
                    });
                }
                $resolvedItems = $resolvedQ->orderByDesc('updated_at')->get()->map(function($g){
                    $studentName = optional($g->student)->first_name
                        ? trim(optional($g->student)->first_name.' '.optional($g->student)->last_name)
                        : ($g->name ?? '');
                    $program = optional($g->student)->program ?? $g->program;
                    return [
                        'id' => $g->id,
                        'case_id' => $g->case_id,
                        'name' => $studentName,
                        'program' => $program,
                        'type' => $g->grievance,
                        'action' => 'resolved',
                        'date' => optional($g->updated_at)->toDateTimeString(),
                    ];
                });

                $deletedQ = GrievanceHistory::where('staff_id', optional($user->staff)->id)
                    ->where('action', 'deleted');
                if ($request->filled('search')) {
                    $search = $request->input('search');
                    // For SQLite JSON as TEXT, coarse LIKE filter
                    $deletedQ->where('snapshot', 'like', "%{$search}%");
                }
                $deletedItems = $deletedQ->orderByDesc('created_at')->get()->map(function($h){
                    $s = $h->snapshot ?? [];
                    return [
                        'id' => $s['id'] ?? null,
                        'case_id' => $s['case_id'] ?? '',
                        'name' => $s['name'] ?? ($s['student_name'] ?? ''),
                        'program' => $s['program'] ?? '',
                        'type' => $s['grievance'] ?? '',
                        'action' => 'deleted',
                        'date' => optional($h->created_at)->toDateTimeString(),
                    ];
                });
                $historyItems = $resolvedItems->concat($deletedItems)->sortByDesc('date')->values();
                $grievances = collect();
            } else {
                // Active tab: limit to pending + in_progress unless specific filter provided
                $query->whereIn('status', ['pending','in_progress']);

                // Filter by status (optional) limited to the active set
                if ($request->filled('status') && in_array($request->status, ['pending','in_progress'])) {
                    $query->where('status', $request->status);
                }

                $grievances = $query->orderByDesc('created_at')->paginate(10)->withQueryString();
            }
        } else {
            $tab = 'active';
            $grievances = collect(); // empty for non-staff users
            $historyItems = collect();
        }

        return view('staff.grievances', [
            'grievances' => $grievances,
            'tab' => $tab,
            'historyItems' => $historyItems ?? collect(),
        ]);
    }

    /**
     * Student-facing grievance list (their own grievances).
     */
    public function studentIndex(Request $request)
    {
        $user = Auth::user();
        $student = $user->student ?? null;

        if (!$student) {
            $grievances = collect();
            return view('student.grievances', compact('grievances'));
        }

    // Use normalized FK `student_record_id` to link to students table
    $query = Grievance::with('staff')->where('student_record_id', $student->id);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('program', 'like', "%{$search}%")
                  ->orWhere('case_id', 'like', "%{$search}%")
                  ->orWhere('grievance', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

    $grievances = $query->orderByDesc('created_at')->paginate(10)->withQueryString();

    return view('student.grievances', compact('grievances', 'student'));
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'program' => 'nullable|string|max:255',
            'date' => 'nullable|date',
            'grievance' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Generate case ID
        $data['case_id'] = 'CASE-' . date('Y') . '-' . str_pad((Grievance::max('id') + 1), 3, '0', STR_PAD_LEFT);
        $data['status'] = 'pending';

        // Try to attach student_record_id
        if (!empty($data['student_id'])) {
            $student = \App\Models\Student::where('student_id', $data['student_id'])->first();
            if ($student) {
                $data['student_record_id'] = $student->id;
            }
        }

        // No need to set filed_by here anymore — model handles it.
        $grievance = Grievance::create($data);

        // Notify all admins about new grievance
        $studentName = $data['name'];
        $this->notifyAllAdmins(
            'grievance',
            'New grievance submitted',
            "Student {$studentName} filed a new case ({$grievance->case_id})",
            [
                'icon' => 'grievance',
                'color' => 'red',
                'link' => route('admin.grievances.show', $grievance->id),
                'related_id' => $grievance->id,
                'related_type' => 'App\Models\Grievance'
            ]
        );

        return redirect()->route('staff.grievances')->with('success', 'Grievance filed successfully.');
    }


    /**
     * Find student by student_id and return basic info for autofill
     */
    public function findStudent($studentId)
    {
        Log::info('findStudent called', ['studentId' => $studentId]);

        $studentIdTrim = trim($studentId);
        $student = \App\Models\Student::where('student_id', $studentIdTrim)->first();

        // Try normalized variants (e.g. remove spaces and dashes)
        if (!$student) {
            $norm = preg_replace('/[^A-Za-z0-9]/', '', $studentIdTrim);
            if ($norm !== $studentIdTrim) {
                $student = \App\Models\Student::whereRaw("REPLACE(REPLACE(student_id, '-', ''), ' ', '') = ?", [$norm])->first();
            }
        }

        if (!$student) {
            Log::info('findStudent not found', ['studentId' => $studentIdTrim]);
            return response()->json(['found' => false], 404);
        }

        // Combine College and Program into one string
        $collegeProgram = trim(($student->college ?? '') . ' | ' . ($student->program ?? ''));

        // Format full name properly
        $fullName = trim($student->first_name . ' ' .
                        ($student->middle_initial ? $student->middle_initial . ' ' : '') .
                        $student->last_name .
                        ($student->suffix ? ' ' . $student->suffix : ''));

        Log::info('findStudent found', ['student_id' => $student->student_id, 'name' => $fullName]);

        return response()->json([
            'found' => true,
            'student' => [
                'name' => $fullName,
                'program' => $collegeProgram, // updated here
            ],
        ]);
    }

    public function create()
    {
        return view('staff.file-grievances');
    }

    /**
     * Update grievance status (staff only)
     */
    public function updateStatus(Request $request, Grievance $grievance)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'staff') {
            abort(403);
        }

        $data = $request->validate([
            'status' => 'required|in:pending,in_progress,resolved',
        ]);

        $old = ['status' => $grievance->status];
        $grievance->status = $data['status'];
        $grievance->save();

        // Audit log
        AuditLog::create([
            'auditable_type' => Grievance::class,
            'auditable_id'   => $grievance->id,
            'action'         => 'status_changed',
            'user_id'        => $user->id,
            'staff_id'       => optional($user->staff)->id,
            'old_values'     => $old,
            'new_values'     => ['status' => $grievance->status],
            'ip_address'     => $request->ip(),
        ]);

        \App\Models\GrievanceHistory::create([
            'grievance_id'=>$grievance->id,
            'action'=>'status_changed',
            'snapshot'=>['old'=>$old,'new'=>['status'=>$grievance->status]],
            'staff_id'=>optional($user->staff)->id,
        ]);

        if ($request->expectsJson()) {
            return response()->json(['ok'=>true,'action'=>'status_changed','status'=>$grievance->status,'id'=>$grievance->id]);
        }
        return back()->with('success', 'Status updated to ' . str_replace('_',' ', $grievance->status));
    }

    /**
     * Delete a grievance (staff only)
     */
    public function destroy(Request $request, Grievance $grievance)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'staff') {
            abort(403);
        }

        $snapshot = $grievance->toArray();
        $grievance->delete();

        AuditLog::create([
            'auditable_type' => Grievance::class,
            'auditable_id'   => $snapshot['id'] ?? 0,
            'action'         => 'deleted',
            'user_id'        => $user->id,
            'staff_id'       => optional($user->staff)->id,
            'old_values'     => $snapshot,
            'new_values'     => null,
            'ip_address'     => $request->ip(),
        ]);

        \App\Models\GrievanceHistory::create([
            'grievance_id'=>$snapshot['id'] ?? null,
            'action'=>'deleted',
            'snapshot'=>$snapshot,
            'staff_id'=>optional($user->staff)->id,
        ]);

        if ($request->expectsJson()) {
            return response()->json(['ok'=>true,'action'=>'deleted','id'=>$snapshot['id'] ?? null]);
        }
        return back()->with('success', 'Grievance deleted.');
    }

    /**
     * Mark grievance resolved (shortcut action via AJAX)
     */
    public function resolve(Request $request, Grievance $grievance)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'staff') {
            abort(403);
        }
        if ($grievance->status !== 'resolved') {
            $old = ['status'=>$grievance->status];
            $grievance->status = 'resolved';
            $grievance->save();
            AuditLog::create([
                'auditable_type'=>Grievance::class,
                'auditable_id'=>$grievance->id,
                'action'=>'status_changed',
                'user_id'=>$user->id,
                'staff_id'=>optional($user->staff)->id,
                'old_values'=>$old,
                'new_values'=>['status'=>'resolved'],
                'ip_address'=>$request->ip(),
            ]);
            \App\Models\GrievanceHistory::create([
                'grievance_id'=>$grievance->id,
                'action'=>'resolved',
                'snapshot'=>['old'=>$old,'new'=>['status'=>'resolved']],
                'staff_id'=>optional($user->staff)->id,
            ]);

            // Notify student about resolution
            if ($grievance->student && $grievance->student->user) {
                $this->notifyGrievanceResolved(
                    $grievance->student->user->id,
                    $grievance->id,
                    $grievance->case_id
                );
            }
        }
        return response()->json(['ok'=>true,'action'=>'resolved','id'=>$grievance->id]);
    }
}
