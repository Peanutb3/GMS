<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage; // Imported here, so we use the alias 'Storage'
use App\Models\Staff;
use App\Models\User;

class StaffProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $staff = Staff::where('user_id', $user->id)->first();

        // Determine view based on role
        $viewPath = match($user->role) {
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
        $viewPath = match($user->role) {
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

        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_initial' => 'nullable|string|max:5',
            'last_name' => 'required|string|max:255',
            'suffix' => 'nullable|string|max:10',
            'department' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:30',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed'
            ,'avatar' => 'nullable|image|max:2048'
        ]);

        // Update staff table
        if ($staff) {
            // handle avatar upload
            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                $path = $file->store('avatars', 'public');

                // delete previous avatar if exists
                if ($staff->avatar) {
                    try {
                        Storage::disk('public')->delete($staff->avatar);
                    } catch (\Exception $e) {
                        // ignore deletion errors
                    }
                }

                $staff->avatar = $path;
            }

            $staff->update([
                'first_name' => $data['first_name'],
                'middle_initial' => $data['middle_initial'] ?? null,
                'last_name' => $data['last_name'],
                'suffix' => $data['suffix'] ?? null,
                'department' => $data['department'] ?? $staff->department,
                'position' => $data['position'] ?? $staff->position,
                'phone' => $data['phone'] ?? $staff->phone,
                'avatar' => $staff->avatar ?? null,
            ]);
        }

        // Update user record
        $user->name = $data['first_name'] . ' ' . $data['last_name'];
        $user->email = $data['email'];
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        $user->save();

        // Redirect based on role
        $redirectRoute = match($user->role) {
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
