<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'staff') {
            return view('staff.dashboard');
        } elseif ($user->role === 'student') {
            return view('student.dashboard');
        } elseif ($user->role === 'admin') {
            return view('admin.dashboard');
        }

        abort(403, 'Unauthorized');
    }
}

// public function index()
// {
//     $grievances = Grievance::latest()->take(5)->get();
//     return view('dashboard', compact('grievances'));
// }
