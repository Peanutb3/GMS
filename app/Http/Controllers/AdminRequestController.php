<?php

namespace App\Http\Controllers;

use App\Models\GoodMoralRequest;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AdminRequestController extends Controller
{
    public function goodMoral(Request $request)
    {
        $query = GoodMoralRequest::with('student');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('student', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('student_no', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $requests = $query->latest()->paginate(15);

        return view('admin.requests-good-moral', compact('requests'));
    }

    public function safeLoan(Request $request)
    {
        // Similar to good moral but for safe loan requests
        // For now, returning a placeholder view
        // You'll need to create the SafeLoanRequest model and migration

        return view('admin.requests-safe-loan');
    }

    public function deleteGoodMoral(GoodMoralRequest $goodMoralRequest)
    {
        // Log the deletion for audit trail
        AuditLog::create([
            'auditable_type' => GoodMoralRequest::class,
            'auditable_id' => $goodMoralRequest->id,
            'action' => 'deleted',
            'user_id' => auth()->id(),
            'staff_id' => optional(auth()->user())->staff_id,
            'old_values' => $goodMoralRequest->snapshot(),
            'new_values' => null,
            'ip_address' => request()->ip(),
        ]);

        $goodMoralRequest->delete();

        return redirect()->route('admin.requests.good-moral')
            ->with('status', 'Good moral request deleted successfully.');
    }
}
