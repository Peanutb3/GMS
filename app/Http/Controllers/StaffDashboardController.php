<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Grievance;

class StaffDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $staffName = $user->name;

        // Prefer staff FK when available; fallback to name snapshot for legacy/self-filed
        if ($user && $user->role === 'staff' && $user->staff) {
            $baseQuery = Grievance::where('filed_by_staff_id', $user->staff->id);
        } else {
            $baseQuery = Grievance::where('filed_by_name_snapshot', $staffName);
        }

    // Summary counts (run efficient queries)
    $totalGrievances = (clone $baseQuery)->count();
    $pendingCases = (clone $baseQuery)->where('status', 'pending')->count();
    $resolvedCases = (clone $baseQuery)->where('status', 'resolved')->count();

    // Recent 2 grievances (latest first)
    $recentGrievances = (clone $baseQuery)->latest('created_at')->take(2)->get();

        return view('staff.dashboard', compact(
            'totalGrievances',
            'pendingCases',
            'resolvedCases',
            'recentGrievances'
        ));
    }
}
