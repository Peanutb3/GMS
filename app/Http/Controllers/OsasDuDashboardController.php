<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grievance;

class OsasDuDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Get statistics for OSAS DU (Discipline Unit)
        $totalGrievances = Grievance::withoutTrashed()->count();
        $pendingGrievances = Grievance::where('status', 'pending')->withoutTrashed()->count();
        $investigatingGrievances = Grievance::where('status', 'in_progress')->withoutTrashed()->count();
        $resolvedGrievances = Grievance::where('status', 'resolved')->withoutTrashed()->count();

        // Recent grievances
        // Only show:
        // - Not deleted (withoutTrashed)
        // - Status is pending/in_progress OR filed within last 30 days
        // - Exclude resolved grievances older than 30 days
        $thirtyDaysAgo = now()->subDays(30);

        $recentGrievances = Grievance::with('student')
            ->withoutTrashed()
            ->where(function ($query) use ($thirtyDaysAgo) {
                $query->whereIn('status', ['pending', 'in_progress'])
                    ->orWhere('created_at', '>=', $thirtyDaysAgo);
            })
            ->where(function ($query) use ($thirtyDaysAgo) {
                // Exclude resolved grievances older than 30 days
                $query->where('status', '!=', 'resolved')
                    ->orWhere('created_at', '>=', $thirtyDaysAgo);
            })
            ->latest('created_at')
            ->take(10)
            ->get();

        return view('staff.osas-du.dashboard', compact(
            'user',
            'totalGrievances',
            'pendingGrievances',
            'investigatingGrievances',
            'resolvedGrievances',
            'recentGrievances'
        ));
    }
}
