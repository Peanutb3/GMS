<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grievance;
use Illuminate\Support\Facades\Auth;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $student = $user->student;

        if (!$student) {
            $myGrievances = collect();
            return view('student.dashboard', compact('user', 'student', 'myGrievances'));
        }

        // Get all grievances and filter them after loading
        // Since student_id is encrypted, we can't do a direct database WHERE comparison
        $myGrievances = Grievance::where('student_record_id', $student->id)
            ->orWhere(function ($q) use ($student) {
                // Get all grievances with a student_no_snapshot
                $q->whereNotNull('student_no_snapshot');
            })
            ->orderByDesc('created_at')
            ->get()
            ->filter(function ($grievance) use ($student) {
                // Filter: either direct link OR student_no_snapshot matches decrypted student_id
                return $grievance->student_record_id === $student->id
                    || $grievance->student_no_snapshot === $student->student_id;
            });

        return view('student.dashboard', compact('user', 'student', 'myGrievances'));
    }
}
