<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grievance;
use App\Models\Student;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class GrievanceController extends Controller
{
    // public function index()
    // {
    //     $grievances = Grievance::orderByDesc('created_at')->get();
    //     return view('staff.grievances', compact('grievances'));
    // }

    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user->role === 'staff' && $user->staff) {
            $query = Grievance::where('filed_by_staff_id', $user->staff->id);

            // Search by name, program, or case ID
            if ($request->filled('search')) {
                $search = $request->input('search');
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                    ->orWhere('program', 'like', "%{$search}%")
                    ->orWhere('case_id', 'like', "%{$search}%");
                });
            }

            // Filter by status (optional)
            if ($request->filled('status') && $request->status !== 'all') {
                $query->where('status', $request->status);
            }

            // Paginate instead of get() so you can use pagination links
            $grievances = $query->orderByDesc('created_at')->paginate(10)->withQueryString();
        } else {
            $grievances = collect(); // empty for non-staff users
        }

        return view('staff.grievances', compact('grievances'));
    }

    /**
     * Student-facing grievance list (their own grievances).
     */
    public function studentIndex(Request $request)
    {
        $user = Auth::user();
        $student = $user->student ?? null;

        if (!$student) {
            $grievances = collect();
            return view('student.grievances', compact('grievances'));
        }

        $query = Grievance::with('staff')->where('student_id', $student->student_id);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('program', 'like', "%{$search}%")
                  ->orWhere('case_id', 'like', "%{$search}%")
                  ->orWhere('grievance', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

    $grievances = $query->orderByDesc('created_at')->paginate(10)->withQueryString();

    return view('student.grievances', compact('grievances', 'student'));
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'program' => 'nullable|string|max:255',
            'date' => 'nullable|date',
            'grievance' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Generate case ID
        $data['case_id'] = 'CASE-' . date('Y') . '-' . str_pad((Grievance::count() + 1), 3, '0', STR_PAD_LEFT);
        $data['status'] = 'pending';

        // No need to set filed_by here anymore — model handles it.
        Grievance::create($data);

        return redirect()->route('staff.grievances')->with('success', 'Grievance filed successfully.');
    }


    /**
     * Find student by student_id and return basic info for autofill
     */
    public function findStudent($studentId)
    {
        \Log::info('findStudent called', ['studentId' => $studentId]);

        $studentIdTrim = trim($studentId);
        $student = \App\Models\Student::where('student_id', $studentIdTrim)->first();

        // Try normalized variants (e.g. remove spaces and dashes)
        if (!$student) {
            $norm = preg_replace('/[^A-Za-z0-9]/', '', $studentIdTrim);
            if ($norm !== $studentIdTrim) {
                $student = \App\Models\Student::whereRaw("REPLACE(REPLACE(student_id, '-', ''), ' ', '') = ?", [$norm])->first();
            }
        }

        if (!$student) {
            \Log::info('findStudent not found', ['studentId' => $studentIdTrim]);
            return response()->json(['found' => false], 404);
        }

        // Combine College and Program into one string
        $collegeProgram = trim(($student->college ?? '') . ' | ' . ($student->program ?? ''));

        // Format full name properly
        $fullName = trim($student->first_name . ' ' .
                        ($student->middle_initial ? $student->middle_initial . ' ' : '') .
                        $student->last_name .
                        ($student->suffix ? ' ' . $student->suffix : ''));

        \Log::info('findStudent found', ['student_id' => $student->student_id, 'name' => $fullName]);

        return response()->json([
            'found' => true,
            'student' => [
                'name' => $fullName,
                'program' => $collegeProgram, // updated here
            ],
        ]);
    }

    public function create()
    {
        return view('staff.file-grievances');
    }
}
