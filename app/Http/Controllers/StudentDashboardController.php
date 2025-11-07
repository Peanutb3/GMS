<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grievance;
use Illuminate\Support\Facades\Auth;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $student = Auth::user()->student;

        // Retrieve grievances that belong to this student
        $myGrievances = Grievance::where('student_id', $student->student_id ?? '')
            ->orderByDesc('created_at')
            ->get();

        return view('student.dashboard', compact('student', 'myGrievances'));
    }
}
