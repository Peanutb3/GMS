<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\Staff;
use App\Models\User;

class StaffProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $staff = Staff::where('user_id', $user->id)->first();

        // Determine view based on role
        $viewPath = match ($user->role) {
            'osas_gmc' => 'staff.osas-gmc.profile',
            'osas_du' => 'staff.osas-du.profile',
            default => 'staff.profile'
        };

        return view($viewPath, compact('user', 'staff'));
    }

    public function edit()
    {
        $user = Auth::user();
        $staff = Staff::where('user_id', $user->id)->first();

        // Determine view based on role
        $viewPath = match ($user->role) {
            'osas_gmc' => 'staff.osas-gmc.profile-edit',
            'osas_du' => 'staff.osas-du.profile-edit',
            default => 'staff.profile-edit'
        };

        return view($viewPath, compact('user', 'staff'));
    }

    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $staff = Staff::where('user_id', $user->id)->first();

        // Debug: Log what we're receiving
        Log::info('Profile Update Request', [
            'has_file' => $request->hasFile('profile_photo'),
            'file_info' => $request->file('profile_photo') ? [
                'name' => $request->file('profile_photo')->getClientOriginalName(),
                'size' => $request->file('profile_photo')->getSize(),
                'mime' => $request->file('profile_photo')->getMimeType(),
            ] : null,
            'all_files' => $request->allFiles(),
        ]);

        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_initial' => 'nullable|string|max:5',
            'last_name' => 'required|string|max:255',
            'suffix' => 'nullable|string|max:10',
            'department' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
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
            ]
        ], [
            'password.min' => 'Password must be at least 8 characters.',
            'password.regex' => 'Password must contain uppercase, lowercase, number, and special character (@$!%*#?&).'
        ]);

        // Update staff table
        if ($staff) {
            // Prepare update data
            $staffData = [
                'first_name' => $data['first_name'],
                'middle_initial' => $data['middle_initial'] ?? null,
                'last_name' => $data['last_name'],
                'suffix' => $data['suffix'] ?? null,
                'department' => $data['department'] ?? $staff->department,
                'position' => $data['position'] ?? $staff->position,
                'phone' => $data['phone'] ?? $staff->phone,
            ];

            // Handle profile photo upload
            if ($request->hasFile('profile_photo')) {
                $file = $request->file('profile_photo');
                $path = $file->store('profile', 'public');

                // Delete previous photo if exists
                if ($staff->profile_photo_path) {
                    try {
                        Storage::disk('public')->delete($staff->profile_photo_path);
                    } catch (\Exception $e) {
                        // ignore deletion errors
                    }
                }

                $staffData['profile_photo_path'] = $path;
            }

            $staff->update($staffData);
        }

        // Update user record
        $user->name = $data['first_name'] . ' ' . $data['last_name'];
        $user->email = $data['email'];
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        $user->save();

        // Redirect based on role
        $redirectRoute = match ($user->role) {
            'osas_gmc' => 'osas-gmc.profile',
            'osas_du' => 'osas-du.profile',
            default => 'staff.profile'
        };

        return redirect()->route($redirectRoute)->with('success', 'Profile updated.');
    }
    public function updatePassword(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        // ensure we have the expected User model instance before calling save()
        if (! $user instanceof User) {
            return redirect()->route('login')->with('error', 'User not authenticated.');
        }

        $data = $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed'
        ]);

        // Verify current password
        if (!Hash::check($data['current_password'], $user->password)) {
            return back()->with('error', 'Current password is incorrect.');
        }

        // Update password
        $user->password = Hash::make($data['password']);
        $user->save();

        // Log out the user after password change
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Password changed successfully. Please login with your new password.');
    }
}
