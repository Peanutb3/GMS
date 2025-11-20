<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class AdminProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('admin.profile-edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'profile_photo' => 'nullable|image|max:2048',
            'password' => 'nullable|string|min:8|confirmed'
        ]);

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $path = $file->store('profile-photos', 'public');

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
        $user = Auth::user();

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
