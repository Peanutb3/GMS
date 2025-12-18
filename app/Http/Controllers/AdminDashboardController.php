<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Grievance;
use App\Models\Student;
use App\Models\GoodMoralRequest;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Overview counts
        $stats = [
            'total_students' => Student::count(),
            'total_staff' => User::whereIn('role', ['staff', 'osas_gmc', 'osas_du'])->count(),
            'total_admins' => User::where('role', 'admin')->count(),
            'total_grievances' => Grievance::count(),
            'pending_grievances' => Grievance::where('status', 'pending')->count(),
            'resolved_grievances' => Grievance::where('status', 'resolved')->count(),
            'total_good_moral' => GoodMoralRequest::count(),
            'pending_good_moral' => GoodMoralRequest::where('status', 'pending')->count(),
        ];

        // Recent grievances (last 7 days)
        $recentGrievances = Grievance::where('created_at', '>=', now()->subDays(7))
            ->latest()
            ->take(5)
            ->get();

        // Monthly grievance trend (last 6 months)
        $monthlyGrievances = Grievance::select(
            DB::raw('DATE_FORMAT(created_at, "%b %Y") as month'),
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as sort_month'),
            DB::raw('COUNT(*) as count')
        )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'), DB::raw('DATE_FORMAT(created_at, "%b %Y")'))
            ->orderBy('sort_month')
            ->get();

        // Grievances by status
        $grievancesByStatus = Grievance::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status');

        // Recent good moral requests (last 7 days)
        $recentGoodMoral = GoodMoralRequest::where('created_at', '>=', now()->subDays(7))
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentGrievances',
            'monthlyGrievances',
            'grievancesByStatus',
            'recentGoodMoral'
        ));
    }
}
