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
        // Include all staff-related roles: staff, osas_gmc, osas_du
        $query = User::with('staff')->whereIn('role', ['staff', 'osas_gmc', 'osas_du']);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Role filter
        if ($request->filled('role') && in_array($request->role, ['staff', 'osas_gmc', 'osas_du'])) {
            $query->where('role', $request->role);
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
            'role' => 'required|in:staff,osas_gmc,osas_du',
            'password' => 'required|min:8|confirmed',
        ]);

        // Build full name
        $fullName = trim($validated['first_name'] . ' ' . 
                        ($validated['middle_initial'] ?? '') . ' ' . 
                        $validated['last_name'] . ' ' . 
                        ($validated['suffix'] ?? ''));

        // Create user account with specified role
        $user = User::create([
            'name' => $fullName,
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'], // Use selected role
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
                    'role' => $validated['role'], // Store role in staff table too
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
        $staff = User::whereIn('role', ['staff', 'osas_gmc', 'osas_du'])->findOrFail($id);
        return view('admin.staff-edit', compact('staff'));
    }

    public function update(Request $request, $id)
    {
        $staff = User::with('staff')->whereIn('role', ['staff', 'osas_gmc', 'osas_du'])->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'department' => 'nullable|string|max:100',
            'staff_type' => 'nullable|string|max:100',
            'role' => 'required|in:staff,osas_gmc,osas_du',
            'password' => 'nullable|min:8|confirmed',
        ]);

        // Update user account
        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'], // Update role
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
                    'role' => $validated['role'], // Update role in staff table
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
        $staff = User::whereIn('role', ['staff', 'osas_gmc', 'osas_du'])->findOrFail($id);
        $staff->delete();

        return response()->json([
            'success' => true,
            'message' => 'Staff member deleted successfully'
        ]);
    }
}
