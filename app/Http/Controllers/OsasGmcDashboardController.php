<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GoodMoralRequest;
use App\Models\SafeLoanRequest;

class OsasGmcDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Get statistics for OSAS GMC (Good Moral Certificate & Safe Loan)
        $totalGoodMoralRequests = GoodMoralRequest::count();
        $pendingGoodMoralRequests = GoodMoralRequest::where('status', 'pending')->count();
        $totalSafeLoanRequests = SafeLoanRequest::count();
        $pendingSafeLoanRequests = SafeLoanRequest::where('status', 'pending')->count();
        
        // Recent requests
        $recentGoodMoral = GoodMoralRequest::with('student')
            ->latest()
            ->take(5)
            ->get();
            
        $recentSafeLoan = SafeLoanRequest::with('student')
            ->latest()
            ->take(5)
            ->get();

        return view('staff.osas-gmc.dashboard', compact(
            'user',
            'totalGoodMoralRequests',
            'pendingGoodMoralRequests',
            'totalSafeLoanRequests',
            'pendingSafeLoanRequests',
            'recentGoodMoral',
            'recentSafeLoan'
        ));
    }
}
