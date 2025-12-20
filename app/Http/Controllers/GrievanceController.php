<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grievance;
use App\Models\Student;
use App\Traits\CreatesNotifications;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
        // Determine view prefix based on role
        $role = $user?->role;
        $viewBase = match ($role) {
            'staff' => 'staff',
            'osas_gmc' => 'staff.osas-gmc',
            'osas_du' => 'staff.osas-du',
            default => 'staff', // fallback
        };

        if (in_array($role, ['staff', 'osas_gmc', 'osas_du']) && ($user->staff || $role !== 'staff')) {
            // GMC: view-only (no history tab) -> show all pending/in_progress grievances
            // DU: full access (all grievances with history)
            // staff: only own filed grievances

            if ($role === 'osas_gmc') {
                // OSAS-GMC: view-only, no history tab
                $query = Grievance::query();

                // Search by name, program, or case ID
                if ($request->filled('search')) {
                    $search = $request->input('search');
                    $query->where(function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('program', 'like', "%{$search}%")
                            ->orWhere('case_id', 'like', "%{$search}%");
                    });
                }

                // Only show active grievances (pending + in_progress)
                $query->whereIn('status', ['pending', 'in_progress']);

                // Filter by status (optional)
                if ($request->filled('status') && in_array($request->status, ['pending', 'in_progress'])) {
                    $query->where('status', $request->status);
                }

                $grievances = $query->orderByDesc('created_at')->paginate(10)->withQueryString();

                return view("{$viewBase}.grievances", [
                    'grievances' => $grievances,
                ]);
            }

            // For OSAS-DU and staff: keep existing history tab logic
            $tab = $request->query('tab', 'active');

            if ($role === 'staff' && $user->staff) {
                $query = Grievance::where('filed_by_staff_id', $user->staff->id);
            } elseif ($role === 'osas_du') {
                $query = Grievance::query();
            } else {
                $query = Grievance::query();
            }

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
                // Build history list: resolved items + deleted snapshots
                // For OSAS-DU: show all resolved/deleted grievances
                // For staff: show only their own filed grievances that are resolved/deleted
                if ($role === 'osas_du') {
                    $resolvedQ = Grievance::where('status', 'resolved');
                } else {
                    $resolvedQ = Grievance::where('filed_by_staff_id', $user->staff->id)
                        ->where('status', 'resolved');
                }

                if ($request->filled('search')) {
                    $search = $request->input('search');
                    $resolvedQ->where(function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('program', 'like', "%{$search}%")
                            ->orWhere('case_id', 'like', "%{$search}%")
                            ->orWhere('grievance', 'like', "%{$search}%");
                    });
                }
                $resolvedItems = $resolvedQ->orderByDesc('updated_at')->get()->map(function ($g) {
                    $studentName = optional($g->student)->first_name
                        ? trim(optional($g->student)->first_name . ' ' . optional($g->student)->last_name)
                        : ($g->name_snapshot ?? $g->name ?? '');
                    $program = optional($g->student)->program ?? ($g->program_snapshot ?? $g->program);
                    $college = optional($g->student)->college ?? ($g->college_snapshot ?? '');
                    $studentId = optional($g->student)->student_id ?? $g->student_no_snapshot;

                    return [
                        'id' => $g->id,
                        'case_id' => $g->case_id,
                        'name' => $studentName,
                        'student_id' => $studentId,
                        'college' => $college,
                        'program' => $program,
                        'type' => $g->grievance,
                        'action' => 'resolved',
                        'date' => optional($g->updated_at)->toDateTimeString(),
                    ];
                });

                // For deleted items: OSAS-DU sees all, staff sees only their own
                if ($role === 'osas_du') {
                    $deletedQ = GrievanceHistory::where('action', 'deleted');
                } else {
                    $deletedQ = GrievanceHistory::where('staff_id', optional($user->staff)->id)
                        ->where('action', 'deleted');
                }

                if ($request->filled('search')) {
                    $search = $request->input('search');
                    // For SQLite JSON as TEXT, coarse LIKE filter
                    $deletedQ->where('snapshot', 'like', "%{$search}%");
                }
                $deletedItems = $deletedQ->orderByDesc('created_at')->get()->map(function ($h) {
                    $s = $h->snapshot ?? [];
                    return [
                        'id' => $s['id'] ?? null,
                        'case_id' => $s['case_id'] ?? '',
                        'name' => $s['name_snapshot'] ?? ($s['name'] ?? ''),
                        'student_id' => $s['student_no_snapshot'] ?? null,
                        'college' => $s['college_snapshot'] ?? ($s['college'] ?? ''),
                        'program' => $s['program_snapshot'] ?? ($s['program'] ?? ''),
                        'type' => $s['grievance'] ?? '',
                        'action' => 'deleted',
                        'date' => optional($h->created_at)->toDateTimeString(),
                    ];
                });
                $historyItems = $resolvedItems->concat($deletedItems)->sortByDesc('date')->values();
                $grievances = collect();
            } else {
                // Active tab: limit to pending + in_progress unless specific filter provided
                $query->whereIn('status', ['pending', 'in_progress']);

                // Filter by status (optional) limited to the active set
                if ($request->filled('status') && in_array($request->status, ['pending', 'in_progress'])) {
                    $query->where('status', $request->status);
                }

                $grievances = $query->orderByDesc('created_at')->paginate(10)->withQueryString();
            }
        } else {
            $tab = 'active';
            $grievances = collect(); // empty for non-staff users
            $historyItems = collect();
        }

        return view("{$viewBase}.grievances", [
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

        // Build query - since student_id is encrypted, we need to filter after loading
        $query = Grievance::with('staff')->where('student_record_id', $student->id)
            ->orWhere(function ($q) {
                $q->whereNotNull('student_no_snapshot');
            });

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

        // Get results and filter by decrypted student_id
        $allResults = $query->orderByDesc('created_at')->get()
            ->filter(function ($grievance) use ($student) {
                return $grievance->student_record_id === $student->id
                    || $grievance->student_no_snapshot === $student->student_id;
            });

        // Manual pagination
        $page = $request->get('page', 1);
        $perPage = 10;
        $offset = ($page - 1) * $perPage;

        $items = $allResults->slice($offset, $perPage)->values();
        $total = $allResults->count();

        $grievances = new \Illuminate\Pagination\LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('student.grievances', compact('grievances', 'student'));
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'college' => 'nullable|string|max:255',
            'program' => 'nullable|string|max:255',
            'date' => 'nullable|date',
            'grievance' => 'required|string|max:255',
            'description' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120', // 5MB max
        ]);

        // If student_id is provided, validate it exists
        if (!empty($data['student_id'])) {
            $studentExists = \App\Models\Student::all()->first(function ($s) use ($data) {
                return $s->student_id === $data['student_id'];
            });

            if (!$studentExists) {
                return back()
                    ->withInput()
                    ->withErrors(['student_id' => 'Student ID not found. Please check and try again.']);
            }
        }

        // Handle file upload
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('grievances/attachments', $filename, 'public');
            $data['attachment_path'] = $path;
        }

        // Wrap entire grievance creation in a transaction to prevent duplicate case_ids
        // Retry up to 3 times in case of race conditions
        $maxRetries = 3;
        $attempt = 0;
        $grievance = null;

        while ($attempt < $maxRetries && !$grievance) {
            try {
                $grievance = \DB::transaction(function () use ($data) {
                    $year = date('y');

                    // Lock the table and get the last case_id for this year (INCLUDING SOFT DELETED)
                    // This prevents case_id duplication when grievances are soft deleted
                    $lastGrievance = Grievance::withTrashed()
                        ->where('case_id', 'like', 'GRV-' . $year . '-%')
                        ->lockForUpdate()
                        ->orderByRaw('CAST(SUBSTRING(case_id, 8) AS UNSIGNED) DESC')
                        ->first();

                    if ($lastGrievance && preg_match('/GRV-' . $year . '-(\d+)/', $lastGrievance->case_id, $matches)) {
                        $count = intval($matches[1]) + 1;
                    } else {
                        $count = 1;
                    }

                    $caseId = 'GRV-' . $year . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);

                    // Double-check this case_id doesn't exist (INCLUDING SOFT DELETED)
                    if (Grievance::withTrashed()->where('case_id', $caseId)->exists()) {
                        throw new \Exception('Case ID already exists, retrying...');
                    }

                    $data['case_id'] = $caseId;
                    $data['status'] = 'pending';

                    // Try to attach student_record_id and populate snapshot fields
                    if (!empty($data['student_id'])) {
                        // Since student_id is encrypted, we need to search all students and compare decrypted values
                        $student = \App\Models\Student::all()->first(function ($s) use ($data) {
                            return $s->student_id === $data['student_id'];
                        });

                        if ($student) {
                            $data['student_record_id'] = $student->id;
                            // Populate snapshot fields from student record
                            $data['name_snapshot'] = $student->first_name . ' ' . $student->last_name;
                            $data['student_no_snapshot'] = $student->student_id;
                            $data['college_snapshot'] = $student->college_name;
                            $data['program_snapshot'] = $student->program_name;
                        } else {
                            // Student ID provided but not found - use form data for snapshots
                            $data['name_snapshot'] = $data['name'];
                            $data['student_no_snapshot'] = $data['student_id'];
                            $data['college_snapshot'] = $data['college'] ?? null;
                            $data['program_snapshot'] = $data['program'] ?? null;
                        }
                    } else {
                        // No student ID - use form data for snapshots
                        $data['name_snapshot'] = $data['name'];
                        $data['student_no_snapshot'] = null;
                        $data['college_snapshot'] = $data['college'] ?? null;
                        $data['program_snapshot'] = $data['program'] ?? null;
                    }

                    // Create the grievance inside the transaction
                    return Grievance::create($data);
                });
            } catch (\Illuminate\Database\UniqueConstraintViolationException $e) {
                $attempt++;
                if ($attempt >= $maxRetries) {
                    throw $e;
                }
                // Wait a bit before retrying (exponential backoff)
                usleep(100000 * $attempt); // 100ms, 200ms, 300ms
            } catch (\Exception $e) {
                $attempt++;
                if ($attempt >= $maxRetries) {
                    return back()->withErrors(['error' => 'Failed to create grievance after multiple attempts. Please try again.']);
                }
                usleep(100000 * $attempt);
            }
        }

        if (!$grievance) {
            return back()->withErrors(['error' => 'Failed to create grievance. Please try again.']);
        }

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

        // Send email notification to student
        $grievance->load('student.user'); // Eager load student and user

        // Try to find student by student_record_id first, then by student_no_snapshot
        $studentUser = null;
        if ($grievance->student && $grievance->student->user) {
            $studentUser = $grievance->student->user;
        } elseif ($grievance->student_no_snapshot) {
            // Since student_id is encrypted, we need to search all students and compare decrypted values
            $student = \App\Models\Student::with('user')->get()->first(function ($s) use ($grievance) {
                return $s->student_id === $grievance->student_no_snapshot;
            });

            if ($student && $student->user) {
                $studentUser = $student->user;
            }
        }

        if ($studentUser && $studentUser->email) {
            try {
                \Mail::to($studentUser->email)
                    ->send(new \App\Mail\GrievanceNotification($grievance, 'new'));
            } catch (\Exception $e) {
                \Log::error('Failed to send grievance notification email: ' . $e->getMessage());
            }
        }

        $redirectRoute = match (Auth::user()?->role) {
            'staff' => 'staff.grievances',
            'osas_du' => 'osas-du.grievances', // DU can file grievances
            default => 'staff.grievances'
        };
        return redirect()->route($redirectRoute)->with('success', 'Grievance filed successfully.');
    }


    /**
     * Find student by student_id and return basic info for autofill
     */
    public function findStudent($studentId)
    {
        try {
            Log::info('findStudent called', [
                'studentId' => $studentId,
                'auth_user' => auth()->id(),
                'route' => request()->url()
            ]);

            $studentIdTrim = trim($studentId);

            if (empty($studentIdTrim)) {
                return response()->json(['found' => false, 'error' => 'Student ID is empty'], 400);
            }

            // Since student_id is encrypted, we need to fetch and check each one
            // Note: This is not optimal for large datasets, but works for moderate sizes
            $student = \App\Models\Student::all()->first(function ($s) use ($studentIdTrim) {
                $decryptedId = $s->student_id; // Auto-decrypted by trait

                // Exact match
                if ($decryptedId === $studentIdTrim) {
                    return true;
                }

                // Try normalized comparison (remove spaces and dashes)
                $norm1 = preg_replace('/[^A-Za-z0-9]/', '', $decryptedId);
                $norm2 = preg_replace('/[^A-Za-z0-9]/', '', $studentIdTrim);
                return $norm1 === $norm2;
            });

            if (!$student) {
                Log::info('findStudent not found', ['studentId' => $studentIdTrim]);
                return response()->json(['found' => false], 404);
            }

            // Combine College and Program into one string using accessors
            $collegeProgram = trim(($student->college_name ?? '') . ' | ' . ($student->program_name ?? ''));

            // Format full name properly
            $fullName = trim($student->first_name . ' ' .
                ($student->middle_initial ? $student->middle_initial . ' ' : '') .
                $student->last_name .
                ($student->suffix ? ' ' . $student->suffix : ''));

            Log::info('findStudent found', [
                'student_id' => $student->student_id,
                'name' => $fullName,
                'college_program' => $collegeProgram
            ]);

            return response()->json([
                'found' => true,
                'student' => [
                    'name' => $fullName,
                    'program' => $collegeProgram,
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('findStudent exception', [
                'studentId' => $studentId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'found' => false,
                'error' => 'An error occurred while looking up the student'
            ], 500);
        }
    }

    public function create()
    {
        $user = Auth::user();
        $role = $user?->role;
        $viewPath = match ($role) {
            'staff' => 'staff.file-grievances',
            'osas_du' => 'staff.osas-du.file-grievances',
            default => abort(403)
        };
        return view($viewPath);
    }

    /**
     * Update grievance status (staff only)
     */
    public function updateStatus(Request $request, Grievance $grievance)
    {
        $user = Auth::user();
        if (!$user || !in_array($user->role, ['staff', 'osas_du'])) {
            abort(403);
        }

        $data = $request->validate([
            'status' => 'required|in:pending,in_progress,resolved',
        ]);

        $old = ['status' => $grievance->status];
        $oldStatus = $grievance->status;
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
            'grievance_id' => $grievance->id,
            'action' => 'status_changed',
            'snapshot' => ['old' => $old, 'new' => ['status' => $grievance->status]],
            'staff_id' => optional($user->staff)->id,
        ]);

        // Send email notification to student about status change
        $studentUser = null;
        if ($grievance->student_record_id && $grievance->student && $grievance->student->user) {
            $studentUser = $grievance->student->user;
        } elseif ($grievance->student_no_snapshot) {
            // Since student_id is encrypted, search all students and compare decrypted values
            $student = \App\Models\Student::with('user')->get()->first(function ($s) use ($grievance) {
                return $s->student_id === $grievance->student_no_snapshot;
            });

            if ($student && $student->user) {
                $studentUser = $student->user;
            }
        }

        if ($studentUser && $studentUser->email) {
            try {
                \Mail::to($studentUser->email)
                    ->send(new \App\Mail\GrievanceNotification($grievance, 'status_update', $oldStatus));
            } catch (\Exception $e) {
                \Log::error('Failed to send status update email: ' . $e->getMessage());
            }
        }

        if ($request->expectsJson()) {
            return response()->json(['ok' => true, 'action' => 'status_changed', 'status' => $grievance->status, 'id' => $grievance->id]);
        }
        return back()->with('success', 'Status updated to ' . str_replace('_', ' ', $grievance->status));
    }

    /**
     * Show a single grievance
     */
    public function show(Grievance $grievance)
    {
        $user = Auth::user();
        if (!$user || !in_array($user->role, ['staff', 'osas_du'])) {
            abort(403);
        }

        $viewBase = match ($user->staff->position ?? '') {
            'OSAS - Director of University' => 'staff.osas-du',
            'OSAS - Guidance and Counseling' => 'staff.osas-gmc',
            default => 'staff.osas-du',
        };

        $history = \App\Models\GrievanceHistory::where('grievance_id', $grievance->id)
            ->with('staff.user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view("{$viewBase}.grievances-show", [
            'grievance' => $grievance,
            'history' => $history,
        ]);
    }

    /**
     * Show edit form for a grievance
     */
    public function edit(Grievance $grievance)
    {
        $user = Auth::user();
        if (!$user || !in_array($user->role, ['staff', 'osas_du'])) {
            abort(403);
        }

        $viewBase = match ($user->staff->position ?? '') {
            'OSAS - Director of University' => 'staff.osas-du',
            'OSAS - Guidance and Counseling' => 'staff.osas-gmc',
            default => 'staff.osas-du',
        };

        return view("{$viewBase}.grievances-show", [
            'grievance' => $grievance,
        ]);
    }

    /**
     * Update a grievance
     */
    public function update(Request $request, Grievance $grievance)
    {
        $user = Auth::user();
        if (!$user || !in_array($user->role, ['staff', 'osas_du'])) {
            abort(403);
        }

        $validated = $request->validate([
            'description' => 'required|string',
            'grievance' => 'required|string',
            'date' => 'required|date',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $oldValues = $grievance->toArray();

        $grievance->description = $validated['description'];
        $grievance->grievance = $validated['grievance'];
        $grievance->date = $validated['date'];

        // Handle file upload
        if ($request->hasFile('attachment')) {
            // Delete old file if exists
            if ($grievance->attachment_path && \Storage::exists('public/' . $grievance->attachment_path)) {
                \Storage::delete('public/' . $grievance->attachment_path);
            }

            $file = $request->file('attachment');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('grievances/attachments', $filename, 'public');
            $grievance->attachment_path = $path;
        }

        $grievance->save();

        AuditLog::create([
            'auditable_type' => Grievance::class,
            'auditable_id' => $grievance->id,
            'action' => 'updated',
            'user_id' => $user->id,
            'staff_id' => optional($user->staff)->id,
            'old_values' => $oldValues,
            'new_values' => $grievance->toArray(),
            'ip_address' => $request->ip(),
        ]);

        $routeName = $user->role === 'osas_du' ? 'osas-du.grievances' : 'staff.grievances';
        return redirect()->route($routeName)->with('success', 'Grievance updated successfully.');
    }

    /**
     * Delete a grievance (staff only)
     */
    public function destroy(Request $request, Grievance $grievance)
    {
        $user = Auth::user();
        if (!$user || !in_array($user->role, ['staff', 'osas_du'])) {
            abort(403);
        }

        try {
            $snapshot = $grievance->toArray();

            // Create history record before deleting
            \App\Models\GrievanceHistory::create([
                'grievance_id' => $grievance->id,
                'action' => 'deleted',
                'snapshot' => $snapshot,
                'staff_id' => optional($user->staff)->id,
            ]);

            // Create audit log
            AuditLog::create([
                'auditable_type' => Grievance::class,
                'auditable_id'   => $grievance->id,
                'action'         => 'deleted',
                'user_id'        => $user->id,
                'staff_id'       => optional($user->staff)->id,
                'old_values'     => $snapshot,
                'new_values'     => null,
                'ip_address'     => $request->ip(),
            ]);

            // Now delete the grievance
            $grievance->delete();

            if ($request->expectsJson()) {
                return response()->json(['ok' => true, 'action' => 'deleted', 'id' => $snapshot['id'] ?? null]);
            }
            return back()->with('success', 'Grievance deleted.');
        } catch (\Exception $e) {
            \Log::error('Grievance deletion error: ' . $e->getMessage());
            if ($request->expectsJson()) {
                return response()->json(['ok' => false, 'error' => $e->getMessage()], 500);
            }
            return back()->with('error', 'Failed to delete grievance: ' . $e->getMessage());
        }
    }

    /**
     * Mark grievance resolved (shortcut action via AJAX)
     */
    public function resolve(Request $request, Grievance $grievance)
    {
        $user = Auth::user();
        if (!$user || !in_array($user->role, ['staff', 'osas_du'])) {
            abort(403);
        }
        if ($grievance->status !== 'resolved') {
            $old = ['status' => $grievance->status];
            $grievance->status = 'resolved';
            $grievance->save();
            AuditLog::create([
                'auditable_type' => Grievance::class,
                'auditable_id' => $grievance->id,
                'action' => 'status_changed',
                'user_id' => $user->id,
                'staff_id' => optional($user->staff)->id,
                'old_values' => $old,
                'new_values' => ['status' => 'resolved'],
                'ip_address' => $request->ip(),
            ]);
            \App\Models\GrievanceHistory::create([
                'grievance_id' => $grievance->id,
                'action' => 'resolved',
                'snapshot' => ['old' => $old, 'new' => ['status' => 'resolved']],
                'staff_id' => optional($user->staff)->id,
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
        return response()->json(['ok' => true, 'action' => 'resolved', 'id' => $grievance->id]);
    }

    /**
     * Add remarks to a grievance
     */
    public function addRemarks(Request $request, Grievance $grievance)
    {
        $user = Auth::user();
        if (!$user || !in_array($user->role, ['staff', 'osas_du'])) {
            abort(403);
        }

        $request->validate([
            'remarks' => 'required|string|max:1000'
        ]);

        $oldRemarks = $grievance->remarks;
        $newRemarks = $request->remarks;

        // Append new remarks with timestamp and user
        $timestamp = now()->format('Y-m-d H:i');
        $userName = $user->name;
        $formattedRemarks = "[{$timestamp}] {$userName}: {$newRemarks}";

        if ($oldRemarks) {
            $grievance->remarks = $oldRemarks . "\n\n" . $formattedRemarks;
        } else {
            $grievance->remarks = $formattedRemarks;
        }

        $grievance->save();

        // Log the action
        AuditLog::create([
            'auditable_type' => Grievance::class,
            'auditable_id' => $grievance->id,
            'action' => 'updated',
            'user_id' => $user->id,
            'staff_id' => optional($user->staff)->id,
            'old_values' => ['remarks' => $oldRemarks],
            'new_values' => ['remarks' => $grievance->remarks],
            'ip_address' => $request->ip(),
        ]);

        return response()->json(['ok' => true, 'message' => 'Remarks added successfully']);
    }
}
