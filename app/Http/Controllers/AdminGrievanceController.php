<?php

namespace App\Http\Controllers;

use App\Models\Grievance;
use App\Models\GrievanceHistory;
use App\Traits\CreatesNotifications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminGrievanceController extends Controller
{
    use CreatesNotifications;
    public function index(Request $request)
    {
        $query = Grievance::query();

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name_snapshot', 'like', "%{$search}%")
                    ->orWhere('student_no_snapshot', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Program filter
        if ($request->filled('program')) {
            $query->where('program_snapshot', $request->program);
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Filed by filter
        if ($request->filled('filed_by')) {
            $query->where('filed_by_name_snapshot', 'like', "%{$request->filed_by}%");
        }

        $grievances = $query->latest()->paginate(10);

        // Get unique programs for filter dropdown
        $programs = Grievance::distinct()
            ->pluck('program_snapshot')
            ->filter()
            ->sort()
            ->values();

        return view('admin.grievances', compact('grievances', 'programs'));
    }

    public function show($id)
    {
        $grievance = Grievance::findOrFail($id);
        $history = GrievanceHistory::where('grievance_id', $id)
            ->latest()
            ->get();

        return view('admin.grievances-show', compact('grievance', 'history'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,resolved,investigating',
        ]);

        $grievance = Grievance::findOrFail($id);
        $oldStatus = $grievance->status;
        $grievance->status = $request->status;
        $grievance->save();

        // Log the change
        GrievanceHistory::create([
            'grievance_id' => $grievance->id,
            'action' => 'status_changed',
            'details' => "Status changed from {$oldStatus} to {$request->status}",
            'performed_by' => Auth::id(),
        ]);

        // Notify student about status change
        if ($grievance->student && $grievance->student->user) {
            $this->notifyGrievanceStatusUpdated(
                $grievance->student->user->id,
                $grievance->id,
                $grievance->case_id,
                ucfirst($request->status)
            );
        }

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

        // If resolved, send resolved notification
        if ($request->status === 'resolved' && $grievance->student && $grievance->student->user) {
            $this->notifyGrievanceResolved(
                $grievance->student->user->id,
                $grievance->id,
                $grievance->case_id
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully'
        ]);
    }

    public function destroy($id)
    {
        $grievance = Grievance::findOrFail($id);

        // Log the deletion
        GrievanceHistory::create([
            'grievance_id' => $grievance->id,
            'action' => 'deleted',
            'details' => "Grievance deleted by admin",
            'performed_by' => Auth::id(),
        ]);

        $grievance->delete();

        return response()->json([
            'success' => true,
            'message' => 'Grievance deleted successfully'
        ]);
    }
}
