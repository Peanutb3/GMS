<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminStudentController extends Controller
{
    public function index(Request $request)
    {
    $query = Student::with('user');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('student_id', 'like', "%{$search}%")
                  ->orWhere('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('program', 'like', "%{$search}%");
            });
        }

        // Program filter
        if ($request->filled('program')) {
            $query->where('program', $request->program);
        }

        // Year level filter
        if ($request->filled('year_level')) {
            $query->where('year', $request->year_level);
        }

        $students = $query->latest()->paginate(15);

        // Get unique programs
        $programs = Student::distinct()
            ->pluck('program')
            ->filter()
            ->sort()
            ->values();

        return view('admin.manage-students', compact('students', 'programs'));
    }

    public function create()
    {
        return view('admin.students-create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_no' => 'required|unique:students',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students',
            'program' => 'required|string|max:255',
            'year_level' => 'required|integer|between:1,5',
            'gender' => 'required|in:Male,Female',
            'date_of_birth' => 'nullable|date',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'password' => 'required|min:8|confirmed',
        ]);

        // Create user account
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'student',
        ]);

        // Create student record
        $student = Student::create([
            'user_id' => $user->id,
            'student_no' => $validated['student_no'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'program' => $validated['program'],
            'year_level' => $validated['year_level'],
            'gender' => $validated['gender'],
            'date_of_birth' => $validated['date_of_birth'] ?? null,
            'phone_number' => $validated['phone_number'] ?? null,
            'address' => $validated['address'] ?? null,
        ]);

        return redirect()->route('admin.manage-students')
            ->with('success', 'Student created successfully');
    }

    public function edit($id)
    {
        $student = Student::with('user')->findOrFail($id);
        return view('admin.students-edit', compact('student'));
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $validated = $request->validate([
            'student_no' => 'required|unique:students,student_no,' . $id,
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $id,
            'program' => 'required|string|max:255',
            'year_level' => 'required|integer|between:1,5',
            'gender' => 'required|in:Male,Female',
            'date_of_birth' => 'nullable|date',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $student->update($validated);

        // Update user email and name
        if ($student->user) {
            $student->user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);
        }

        return redirect()->route('admin.manage-students')
            ->with('success', 'Student updated successfully');
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        
        // Delete user account if exists
        if ($student->user) {
            $student->user->delete();
        }

        // Delete profile photo if exists
        if ($student->profile_photo_path) {
            Storage::disk('public')->delete($student->profile_photo_path);
        }

        $student->delete();

        return response()->json([
            'success' => true,
            'message' => 'Student deleted successfully'
        ]);
    }
}
