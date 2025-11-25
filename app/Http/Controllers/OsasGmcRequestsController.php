<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GoodMoralRequest;
use App\Models\SafeLoanRequest;

class OsasGmcRequestsController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'goodmoral');
        
        // Good Moral Requests
        $goodMoralQuery = GoodMoralRequest::with('student');
        if ($request->filled('gm_search')) {
            $search = $request->gm_search;
            $goodMoralQuery->where(function($q) use ($search) {
                $q->where('reference_no', 'like', "%{$search}%")
                  ->orWhere('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%");
            });
        }
        if ($request->filled('gm_status')) {
            $goodMoralQuery->where('status', $request->gm_status);
        }
        $goodMorals = $goodMoralQuery->latest()->get();
        
        // Safe Loan Requests
        $safeLoanQuery = SafeLoanRequest::with('student');
        if ($request->filled('sl_search')) {
            $search = $request->sl_search;
            $safeLoanQuery->where(function($q) use ($search) {
                $q->where('reference_no', 'like', "%{$search}%")
                  ->orWhere('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%");
            });
        }
        if ($request->filled('sl_status')) {
            $safeLoanQuery->where('status', $request->sl_status);
        }
        $safeLoans = $safeLoanQuery->latest()->get();
        
        return view('staff.osas-gmc.requests', compact(
            'goodMorals',
            'safeLoans',
            'tab'
        ));
    }
    
    public function check(Request $request, $type, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,ready,released,rejected'
        ]);
        
        if ($type === 'goodmoral') {
            $req = GoodMoralRequest::findOrFail($id);
        } else {
            $req = SafeLoanRequest::findOrFail($id);
        }
        
        $req->update([
            'status' => $validated['status'],
            'staff_id' => optional(auth()->user()->staff)->id
        ]);
        
        return response()->json(['success' => true]);
    }
}
