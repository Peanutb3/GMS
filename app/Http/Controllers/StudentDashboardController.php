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
            $recentGrievances = collect();
            $totalGrievances = collect();
            return view('student.dashboard', compact('user', 'student', 'recentGrievances', 'totalGrievances'));
        }

        // Get recent grievances (last 7 days) for dashboard preview
        $recentGrievances = Grievance::where('student_record_id', $student->id)
            ->orWhere(function ($q) use ($student) {
                $q->whereNotNull('student_no_snapshot');
            })
            ->where('created_at', '>=', now()->subDays(7))
            ->orderByDesc('created_at')
            ->take(5)
            ->get()
            ->filter(function ($grievance) use ($student) {
                return $grievance->student_record_id === $student->id
                    || $grievance->student_no_snapshot === $student->student_id;
            });

        // Get total counts for summary cards (all time)
        $totalGrievances = Grievance::where('student_record_id', $student->id)
            ->orWhere(function ($q) use ($student) {
                $q->whereNotNull('student_no_snapshot');
            })
            ->get()
            ->filter(function ($grievance) use ($student) {
                return $grievance->student_record_id === $student->id
                    || $grievance->student_no_snapshot === $student->student_id;
            });

        return view('student.dashboard', compact('user', 'student', 'recentGrievances', 'totalGrievances'));
    }
}
