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

        // Resolve college/program names safely. Student.college/program may contain either a name or an id.
        $collegeName = null;
        $programName = null;

        if ($student) {
            try {
                if (!empty($student->college) && is_numeric($student->college)) {
                    $col = \App\Models\College::find((int) $student->college);
                    $collegeName = $col ? $col->name : $student->college;
                } else {
                    $collegeName = $student->college;
                }

                if (!empty($student->program) && is_numeric($student->program)) {
                    $prog = \App\Models\Program::find((int) $student->program);
                    $programName = $prog ? $prog->name : $student->program;
                } else {
                    $programName = $student->program;
                }
            } catch (\Throwable $e) {
                $collegeName = $student->college;
                $programName = $student->program;
            }
        }

        return view('student.profile', compact('user', 'student', 'collegeName', 'programName'));
    }

    public function edit()
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->first();

        // resolve display names for edit form as well
        $collegeName = null;
        $programName = null;
        if ($student) {
            try {
                if (!empty($student->college) && is_numeric($student->college)) {
                    $col = \App\Models\College::find((int) $student->college);
                    $collegeName = $col ? $col->name : $student->college;
                } else {
                    $collegeName = $student->college;
                }

                if (!empty($student->program) && is_numeric($student->program)) {
                    $prog = \App\Models\Program::find((int) $student->program);
                    $programName = $prog ? $prog->name : $student->program;
                } else {
                    $programName = $student->program;
                }
            } catch (\Throwable $e) {
                $collegeName = $student->college;
                $programName = $student->program;
            }
        }

        return view('student.profile-edit', compact('user', 'student', 'collegeName', 'programName'));
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
            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/'
            ],
            'profile_photo' => [
                'nullable',
                'image',
                'mimes:jpeg,jpg,png',
                'max:2048',
                'dimensions:max_width=2000,max_height=2000'
            ],
        ], [
            'password.min' => 'Password must be at least 8 characters.',
            'password.regex' => 'Password must contain uppercase, lowercase, number, and special character (@$!%*#?&).'
        ]);

        if ($student) {
            // Handle base64 cropped image from cropper
            if ($request->filled('profile_photo') && strpos($request->profile_photo, 'data:image') === 0) {
                // Extract base64 data
                $image_parts = explode(";base64,", $request->profile_photo);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);

                // Generate secure filename
                $filename = \Illuminate\Support\Str::uuid() . '.' . $image_type;
                $path = 'profile-photos/' . $filename;

                // Save to storage
                Storage::disk('public')->put($path, $image_base64);

                // Delete old photo if exists
                if (!empty($student->profile_photo_path)) {
                    try {
                        Storage::disk('public')->delete($student->profile_photo_path);
                    } catch (\Exception $e) {
                    }
                }

                $student->profile_photo_path = $path;
            }
            // Handle regular file upload (fallback)
            elseif ($request->hasFile('profile_photo')) {
                $file = $request->file('profile_photo');

                // Generate secure filename
                $filename = \Illuminate\Support\Str::uuid() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('profile-photos', $filename, 'public');

                if (!empty($student->profile_photo_path)) {
                    try {
                        Storage::disk('public')->delete($student->profile_photo_path);
                    } catch (\Exception $e) {
                    }
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

    public function showChangePassword()
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->first();

        return view('student.change-password', compact('user', 'student'));
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
            ],
        ], [
            'password.min' => 'Password must be at least 8 characters.',
            'password.regex' => 'Password must contain uppercase, lowercase, and number.'
        ]);

        // Check if current password matches
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        // Update password
        $user->password = Hash::make($request->password);
        $user->save();

        // Log out user
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Password changed successfully. Please login with your new password.');
    }
}
