<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountApprovedNotification;

class UserApprovalController extends Controller
{
    /**
     * Display list of pending user approvals
     */
    public function index()
    {
        $pendingUsers = User::where('role', 'student')
            ->where('is_approved', false)
            ->with('student')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.user-approvals.index', compact('pendingUsers'));
    }

    /**
     * Approve a user account
     */
    public function approve($id)
    {
        $user = User::findOrFail($id);

        if ($user->is_approved) {
            return back()->with('info', 'User is already approved.');
        }

        $user->update([
            'is_approved' => true,
            'approved_at' => now(),
            'approved_by' => Auth::id(),
        ]);

        // Log the approval
        AuditLog::create([
            'auditable_type' => User::class,
            'auditable_id' => $user->id,
            'action' => 'user_approved',
            'user_id' => Auth::id(),
            'staff_id' => Auth::user()->staff->id ?? null,
            'old_values' => ['is_approved' => false],
            'new_values' => ['is_approved' => true, 'approved_at' => now()],
            'ip_address' => request()->ip(),
        ]);

        // Send approval email notification
        try {
            Mail::to($user->email)->send(new AccountApprovedNotification($user));
        } catch (\Exception $e) {
            \Log::error('Failed to send approval email: ' . $e->getMessage());
        }

        return back()->with('success', 'User account approved successfully.');
    }

    /**
     * Reject a user account
     */
    public function reject(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        // Log the rejection
        AuditLog::create([
            'auditable_type' => User::class,
            'auditable_id' => $user->id,
            'action' => 'user_rejected',
            'user_id' => Auth::id(),
            'staff_id' => Auth::user()->staff->id ?? null,
            'old_values' => null,
            'new_values' => ['rejection_reason' => $request->rejection_reason],
            'ip_address' => request()->ip(),
        ]);

        // Delete the user account
        $user->delete();

        return back()->with('success', 'User account rejected and deleted.');
    }
}
