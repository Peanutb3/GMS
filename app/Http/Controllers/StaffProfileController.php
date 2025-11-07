<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Staff;
use App\Models\User;

class StaffProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $staff = Staff::where('user_id', $user->id)->first();

        return view('staff.profile', compact('user', 'staff'));
    }

    public function edit()
    {
        $user = Auth::user();
        $staff = Staff::where('user_id', $user->id)->first();

        return view('staff.profile-edit', compact('user', 'staff'));
    }

    public function update(Request $request)
    {
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
                        \Storage::disk('public')->delete($staff->avatar);
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

        return redirect()->route('staff.profile')->with('success', 'Profile updated.');
    }
}
