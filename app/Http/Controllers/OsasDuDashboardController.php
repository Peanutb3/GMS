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
        $totalGrievances = Grievance::count();
        $pendingGrievances = Grievance::where('status', 'pending')->count();
        $investigatingGrievances = Grievance::where('status', 'investigating')->count();
        $resolvedGrievances = Grievance::where('status', 'resolved')->count();
        
        // Recent grievances
        $recentGrievances = Grievance::with('student')
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
