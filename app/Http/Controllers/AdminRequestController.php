<?php

namespace App\Http\Controllers;

use App\Models\GoodMoralRequest;
use App\Models\SafeLoanRequest;
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
        $query = SafeLoanRequest::with(['student', 'staff']);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('reference_no', 'like', "%{$search}%")
                    ->orWhere('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhereHas('student', function ($sq) use ($search) {
                        $sq->where('student_id', 'like', "%{$search}%");
                    });
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

        return view('admin.requests-safe-loan', compact('requests'));
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

    public function enterOrNumber(Request $request, $id)
    {
        $request->validate([
            'or_number' => 'required|string|max:50',
        ]);

        $safeLoanRequest = SafeLoanRequest::findOrFail($id);

        $safeLoanRequest->or_number = $request->or_number;
        $safeLoanRequest->or_entered_at = now();
        $safeLoanRequest->save();

        // Log the OR entry
        AuditLog::create([
            'auditable_type' => SafeLoanRequest::class,
            'auditable_id' => $safeLoanRequest->id,
            'action' => 'or_entered',
            'user_id' => auth()->id(),
            'staff_id' => optional(auth()->user())->staff_id,
            'old_values' => null,
            'new_values' => ['or_number' => $request->or_number],
            'ip_address' => request()->ip(),
        ]);

        return redirect()->route('admin.requests.safe-loan')
            ->with('status', 'OR number saved successfully.');
    }

    public function deleteSafeLoan(SafeLoanRequest $safeLoanRequest)
    {
        // Log the deletion for audit trail
        AuditLog::create([
            'auditable_type' => SafeLoanRequest::class,
            'auditable_id' => $safeLoanRequest->id,
            'action' => 'deleted',
            'user_id' => auth()->id(),
            'staff_id' => optional(auth()->user())->staff_id,
            'old_values' => $safeLoanRequest->toArray(),
            'new_values' => null,
            'ip_address' => request()->ip(),
        ]);

        $safeLoanRequest->delete();

        return redirect()->route('admin.requests.safe-loan')
            ->with('status', 'Safe loan request deleted successfully.');
    }
}
