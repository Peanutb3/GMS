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

        // Retrieve grievances by the normalized FK (student_record_id)
        $myGrievances = Grievance::where('student_record_id', $student->id ?? null)
            ->orderByDesc('created_at')
            ->get();

        return view('student.dashboard', compact('student', 'myGrievances'));
    }
}
