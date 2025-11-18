<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class AdminStaffController extends Controller
{
    public function index(Request $request)
    {
    $query = User::with('staff')->where('role', 'staff');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $staff = $query->latest()->paginate(15);

    return view('admin.manage-staff', compact('staff'));
    }

    public function create()
    {
        return view('admin.staff-create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|unique:staff,employee_id',
            'first_name' => 'required|string|max:255',
            'middle_initial' => 'nullable|string|max:2',
            'last_name' => 'required|string|max:255',
            'suffix' => 'nullable|string|max:10',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'department' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'staff_type' => 'required|in:Academic,Non-Academic,Administrative',
            'password' => 'required|min:8|confirmed',
        ]);

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
            'role' => 'staff',
        ]);

        // Create staff profile if table exists
        try {
            if (Schema::hasTable('staff')) {
                Staff::create([
                    'user_id' => $user->id,
                    'employee_id' => $validated['employee_id'],
                    'first_name' => $validated['first_name'],
                    'middle_initial' => $validated['middle_initial'] ?? null,
                    'last_name' => $validated['last_name'],
                    'suffix' => $validated['suffix'] ?? null,
                    'email' => $validated['email'],
                    'phone' => $validated['phone'] ?? null,
                    'department' => $validated['department'],
                    'position' => $validated['position'],
                    'staff_type' => $validated['staff_type'],
                    'role' => 'staff',
                ]);
            }
        } catch (\Throwable $e) {
            // Rollback user if staff creation fails
            $user->delete();
            throw $e;
        }

        return redirect()->route('admin.manage-staff')
            ->with('success', 'Staff member created successfully');
    }

    public function edit($id)
    {
        $staff = User::where('role', 'staff')->findOrFail($id);
        return view('admin.staff-edit', compact('staff'));
    }

    public function update(Request $request, $id)
    {
        $staff = User::with('staff')->where('role', 'staff')->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'department' => 'nullable|string|max:100',
            'staff_type' => 'nullable|string|max:100',
            'password' => 'nullable|min:8|confirmed',
        ]);

        // Update user account
        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];

        // Update password if provided
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($validated['password']);
        }

        $staff->update($userData);

        // Sync Staff profile if table exists
        try {
            if (Schema::hasTable('staff') && $staff->staff) {
                $staff->staff->update([
                    'email' => $validated['email'],
                    'department' => $validated['department'] ?? $staff->staff->department,
                    'staff_type' => $validated['staff_type'] ?? $staff->staff->staff_type,
                ]);
            }
        } catch (\Throwable $e) {
            // ignore silently
        }

        return redirect()->route('admin.manage-staff')
            ->with('success', 'Staff member updated successfully');
    }

    public function destroy($id)
    {
        $staff = User::where('role', 'staff')->findOrFail($id);
        $staff->delete();

        return response()->json([
            'success' => true,
            'message' => 'Staff member deleted successfully'
        ]);
    }
}
