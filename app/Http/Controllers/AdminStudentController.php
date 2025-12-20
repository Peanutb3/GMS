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
            $query->where(function ($q) use ($search) {
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
        $colleges = \App\Models\College::active()->orderBy('name')->get();
        $programs = \App\Models\Program::active()->with('college')->orderBy('name')->get();
        return view('admin.students-create', compact('colleges', 'programs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|unique:students,student_id',
            'first_name' => 'required|string|max:255',
            'middle_initial' => 'nullable|string|max:2',
            'last_name' => 'required|string|max:255',
            'suffix' => 'nullable|string|max:10',
            'email' => 'required|email|unique:users,email',
            'college' => 'required|exists:colleges,id',
            'program' => 'required|exists:programs,id',
            'year' => 'required|string|max:10',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&_\-]/'
            ],
        ]);

        // Get college and program names
        $college = \App\Models\College::findOrFail($validated['college']);
        $program = \App\Models\Program::findOrFail($validated['program']);

        // Build full name
        $fullName = trim($validated['first_name'] . ' ' .
            ($validated['middle_initial'] ?? '') . ' ' .
            $validated['last_name'] . ' ' .
            ($validated['suffix'] ?? ''));

        // Create user account
        $user = User::create([
            'name' => $fullName,
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'student',
        ]);

        // Create student record
        $student = Student::create([
            'user_id' => $user->id,
            'student_id' => $validated['student_id'],
            'first_name' => $validated['first_name'],
            'middle_initial' => $validated['middle_initial'] ?? null,
            'last_name' => $validated['last_name'],
            'suffix' => $validated['suffix'] ?? null,
            'college' => $college->name,
            'program' => $program->name,
            'year' => $validated['year'],
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
        $student = Student::with('user')->findOrFail($id);

        $validated = $request->validate([
            'student_id' => 'required|unique:students,student_id,' . $id,
            'first_name' => 'required|string|max:255',
            'middle_initial' => 'nullable|string|max:2',
            'last_name' => 'required|string|max:255',
            'suffix' => 'nullable|string|max:10',
            'email' => 'required|email|unique:users,email,' . $student->user_id,
            'college' => 'required|string|max:255',
            'program' => 'required|string|max:255',
            'year' => 'required|string|max:10',
            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&_\-]/'
            ],
        ]);

        // Build full name
        $fullName = trim($validated['first_name'] . ' ' .
            ($validated['middle_initial'] ?? '') . ' ' .
            $validated['last_name'] . ' ' .
            ($validated['suffix'] ?? ''));

        // Update student record
        $student->update([
            'student_id' => $validated['student_id'],
            'first_name' => $validated['first_name'],
            'middle_initial' => $validated['middle_initial'] ?? null,
            'last_name' => $validated['last_name'],
            'suffix' => $validated['suffix'] ?? null,
            'college' => $validated['college'],
            'program' => $validated['program'],
            'year' => $validated['year'],
        ]);

        // Update user account
        if ($student->user) {
            $userData = [
                'name' => $fullName,
                'email' => $validated['email'],
            ];

            // Update password if provided
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($validated['password']);
            }

            $student->user->update($userData);
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

        return redirect()->route('admin.manage-students')
            ->with('success', 'Student deleted successfully');
    }
}
