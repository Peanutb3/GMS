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
        $investigatingGrievances = Grievance::where('status', 'investigating')->withoutTrashed()->count();
        $resolvedGrievances = Grievance::where('status', 'resolved')->withoutTrashed()->count();

        // Recent grievances
        $recentGrievances = Grievance::with('student')
            ->withoutTrashed()
            ->latest()
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
