<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\GoodMoralRequest;
use App\Models\SafeLoanRequest;
use App\Models\Grievance;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $query = AuditLog::query()->latest();

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        if ($request->filled('staff_id')) {
            $query->where('staff_id', $request->staff_id);
        }
        if ($request->filled('from')) {
            $query->whereDate('created_at','>=',$request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at','<=',$request->to);
        }

        // Role-based visibility: staff should not see "request created" events
        $user = $request->user();
        if ($user && ($user->role ?? null) === 'staff') {
            $query->whereNot(function ($q) {
                $q->whereIn('auditable_type', [GoodMoralRequest::class, SafeLoanRequest::class])
                  ->where('action', 'created');
            });
        }

        $type = strtolower((string) $request->query('type', ''));
        if ($type === 'requests') {
            $query->whereIn('auditable_type', [GoodMoralRequest::class, SafeLoanRequest::class]);
        } elseif ($type === 'grievances') {
            if (class_exists(Grievance::class)) {
                $query->where('auditable_type', Grievance::class);
            }
        }

    $logs = $query->paginate(50)->withQueryString();

    return view('staff.logs', [
            'logs' => $logs,
            'type' => $type,
        ]);
    }

    public function adminIndex(Request $request)
    {
        $query = AuditLog::with('user');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('action', 'like', "%{$search}%")
                  ->orWhere('details', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Action filter
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // User filter
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $logs = $query->latest()->paginate(20);

        // Get unique actions for filter dropdown
        $actions = AuditLog::distinct()
            ->pluck('action')
            ->filter()
            ->sort()
            ->values();

        return view('admin.audit-logs', compact('logs', 'actions'));
    }
}
