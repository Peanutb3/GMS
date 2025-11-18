<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GoodMoralRequest;
use App\Models\SafeLoanRequest;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class StaffRequestsController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'goodmoral');

        // Fetch recent records; eager-load staff for display if present
        $goodMorals = GoodMoralRequest::with('staff')
            ->latest()
            ->take(100)
            ->get();

        $safeLoans = SafeLoanRequest::with('staff')
            ->latest()
            ->take(100)
            ->get();

        return view('staff.requests', compact('tab', 'goodMorals', 'safeLoans'));
    }

    public function check(Request $request, string $type, int $id)
    {
        $user = $request->user();
        $staffId = optional($user->staff)->id;

        if ($type === 'goodmoral') {
            $model = GoodMoralRequest::findOrFail($id);
        } elseif ($type === 'safeloan') {
            $model = SafeLoanRequest::findOrFail($id);
        } else {
            abort(404);
        }

        // Minimal status flow: mark as 'checked' and set staff_id if available
        $old = $model->snapshot ?? (method_exists($model,'snapshot') ? $model->snapshot() : $model->getAttributes());
        $model->status = 'checked';
        if ($staffId) {
            $model->staff_id = $staffId;
        }
        $model->save();

        AuditLog::create([
            'auditable_type' => get_class($model),
            'auditable_id' => $model->id,
            'action' => 'status_changed',
            'user_id' => optional($user)->id,
            'staff_id' => $staffId,
            'old_values' => ['status' => $old['status'] ?? null],
            'new_values' => ['status' => $model->status],
            'ip_address' => $request->ip(),
        ]);

        return redirect()
            ->route('staff.requests', ['tab' => $type === 'goodmoral' ? 'goodmoral' : 'safeloan'])
            ->with('status', 'Request marked as checked.');
    }
}
