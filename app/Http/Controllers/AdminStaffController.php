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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'staff_type' => 'nullable|string|max:100',
            'department' => 'nullable|string|max:100',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'staff',
        ]);

        // If Staff profile table exists, create/update a profile row
        try {
            if (Schema::hasTable('staff')) {
                Staff::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'first_name' => $user->name, // simple seed; real form can collect properly
                        'last_name' => '',
                        'email' => $user->email,
                        'department' => $validated['department'] ?? null,
                        'staff_type' => $validated['staff_type'] ?? null,
                        'role' => 'staff',
                        'employee_id' => 'EMP-' . str_pad((string)$user->id, 5, '0', STR_PAD_LEFT),
                    ]
                );
            }
        } catch (\Throwable $e) {
            // non-fatal; view will still show N/A if profile missing
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
        $staff = User::where('role', 'staff')->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'staff_type' => 'nullable|string|max:100',
            'department' => 'nullable|string|max:100',
        ]);

        $staff->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        // Sync Staff profile if table exists
        try {
            if (Schema::hasTable('staff')) {
                Staff::updateOrCreate(
                    ['user_id' => $staff->id],
                    [
                        'first_name' => $validated['name'],
                        'email' => $validated['email'],
                        'department' => $validated['department'] ?? null,
                        'staff_type' => $validated['staff_type'] ?? null,
                    ]
                );
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
