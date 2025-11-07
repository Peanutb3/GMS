<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Student;
use App\Models\User;

class StudentProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->first();

        return view('student.profile', compact('user', 'student'));
    }

    public function edit()
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->first();

        return view('student.profile-edit', compact('user', 'student'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->first();

        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_initial' => 'nullable|string|max:5',
            'last_name' => 'required|string|max:255',
            'suffix' => 'nullable|string|max:10',
            'college' => 'nullable|string|max:255',
            'program_and_year' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:30',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
            'profile_photo' => 'nullable|image|max:2048',
        ]);

        if ($student) {
            if ($request->hasFile('profile_photo')) {
                $file = $request->file('profile_photo');
                $path = $file->store('profile-photos', 'public');

                if (!empty($student->profile_photo_path)) {
                    try { Storage::disk('public')->delete($student->profile_photo_path); } catch (\Exception $e) {}
                }

                $student->profile_photo_path = $path;
            }

            $student->update([
                'first_name' => $data['first_name'],
                'middle_initial' => $data['middle_initial'] ?? $student->middle_initial,
                'last_name' => $data['last_name'],
                'suffix' => $data['suffix'] ?? $student->suffix,
                'college' => $data['college'] ?? $student->college,
                'program_and_year' => $data['program_and_year'] ?? $student->program_and_year,
                'phone' => $data['phone'] ?? $student->phone,
                'profile_photo_path' => $student->profile_photo_path ?? $student->profile_photo_path,
            ]);
        }

        $user->name = $data['first_name'] . ' ' . $data['last_name'];
        $user->email = $data['email'];
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        $user->save();

        return redirect()->route('student.profile')->with('success', 'Profile updated.');
    }
}
