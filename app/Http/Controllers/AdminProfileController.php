<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class AdminProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('admin.profile', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('admin.profile-edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'profile_photo' => 'nullable|string', // Can be base64 string
            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/'
            ]
        ], [
            'password.min' => 'Password must be at least 8 characters.',
            'password.regex' => 'Password must contain uppercase, lowercase, number, and special character (@$!%*#?&).'
        ]);

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
            if (!empty($user->profile_photo_path)) {
                try {
                    Storage::disk('public')->delete($user->profile_photo_path);
                } catch (\Exception $e) {
                }
            }

            $user->profile_photo_path = $path;
        }
        // Handle regular file upload (fallback)
        elseif ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');

            // Generate secure filename
            $filename = \Illuminate\Support\Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('profile-photos', $filename, 'public');

            // Delete previous photo if exists
            if ($user->profile_photo_path) {
                try {
                    Storage::disk('public')->delete($user->profile_photo_path);
                } catch (\Exception $e) {
                    // Ignore deletion errors
                }
            }

            $user->profile_photo_path = $path;
        }

        // Update user record
        $user->name = $data['name'];
        $user->email = $data['email'];

        // Only update password if provided
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return redirect()->route('admin.profile')->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        $data = $request->validate([
            'current_password' => 'required|string',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/'
            ]
        ], [
            'password.min' => 'Password must be at least 8 characters.',
            'password.regex' => 'Password must contain uppercase, lowercase, number, and special character (@$!%*#?&).'
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
