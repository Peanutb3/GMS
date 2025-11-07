<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Grievance;
use App\Models\Student;
use App\Models\Staff;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalStudents = Student::count();
        $totalStaff = Staff::count();
        $totalGrievances = Grievance::count();

        $recentGrievances = Grievance::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalStudents',
            'totalStaff',
            'totalGrievances',
            'recentGrievances'
        ));
    }
}
