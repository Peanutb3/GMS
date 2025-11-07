<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use App\Models\Staff;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * ---------------------------
     * MULTI-STEP SIGNUP
     * ---------------------------
     */
    public function showStep1()
    {
        return view('signup-step1');
    }

    public function storeStep1(Request $request)
    {
        $validated = $request->validate([
            'account_type'   => 'required|in:student,staff',
            // Student-specific
            'student_id'     => 'required_if:account_type,student|unique:students,student_id',
            'college'        => 'required_if:account_type,student',
            'program'        => 'required_if:account_type,student',
            'year'           => 'required_if:account_type,student',
            // Staff-specific
            'employee_id'    => 'required_if:account_type,staff|unique:staff,employee_id',
            'staff_type'     => 'required_if:account_type,staff',
            'department'     => 'required_if:account_type,staff',
            'position'       => 'required_if:account_type,staff',
            'phone'          => 'required_if:account_type,staff',
            // Common fields
            'first_name'     => 'required|string|max:255',
            'middle_initial' => 'nullable|string|max:5',
            'last_name'      => 'required|string|max:255',
            'suffix'         => 'nullable|string|max:10',
        ]);

        session(['signup_step1' => $validated]);

        return redirect()->route('signup.step2');
    }

    public function showStep2()
    {
        if (!session()->has('signup_step1')) {
            return redirect()->route('signup.step1')
                ->with('error', 'Please complete Step 1 first.');
        }

        return view('signup-step2');
    }

    public function storeStep2(Request $request)
    {
        $step1 = session('signup_step1');
        if (!$step1) {
            return redirect()->route('signup.step1');
        }

        $data = $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $step1['first_name'].' '.$step1['last_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role' => $step1['account_type'],
        ]);

        if ($step1['account_type'] === 'student') {
            Student::create([
                'user_id'        => $user->id,
                'student_id'     => $step1['student_id'],
                'first_name'     => $step1['first_name'],
                'middle_initial' => $step1['middle_initial'] ?? null,
                'last_name'      => $step1['last_name'],
                'suffix'         => $step1['suffix'] ?? null,
                'college'        => $step1['college'],
                'program'        => $step1['program'],
                'year'           => $step1['year'],
            ]);
        } elseif ($step1['account_type'] === 'staff') {
            Staff::create([
                'user_id'        => $user->id,
                'employee_id'    => $step1['employee_id'],
                'first_name'     => $step1['first_name'],
                'middle_initial' => $step1['middle_initial'] ?? null,
                'last_name'      => $step1['last_name'],
                'suffix'         => $step1['suffix'] ?? null,
                'department'     => $step1['department'],
                'position'       => $step1['position'],
                'phone'          => $step1['phone'],
                'staff_type'     => $step1['staff_type'],
            ]);
        }

        session()->forget('signup_step1');

        return redirect()->route('login')
            ->with('success', 'Account created successfully!');
    }

    /**
     * ---------------------------
     * LOGIN / LOGOUT
     * ---------------------------
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
        $user = Auth::user();

        // Redirect them to their dashboard if already logged in
        return match ($user->role) {
            'student' => redirect()->route('student.dashboard'),
            'staff' => redirect()->route('staff.dashboard'),
            'admin' => redirect()->route('admin.dashboard'),
            default => redirect()->route('dashboard'),
        };
    }

    return view('auth.login');

    }

    public function login(Request $request)
    {
        // Validate input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Check if user exists
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'No account found with this email.'])->onlyInput('email');
        }

        // Setup rate limiter key
        $key = \Illuminate\Support\Str::lower($request->email) . '|' . $request->ip();

        // Check if too many attempts
        if (\Illuminate\Support\Facades\RateLimiter::tooManyAttempts($key, 5)) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'password' => 'Too many login attempts. Please try again in a few minutes.',
            ]);
        }

        // Attempt login
        $remember = $request->filled('remember');
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember)) {
            // Clear failed attempts on successful login
            \Illuminate\Support\Facades\RateLimiter::clear($key);

            $request->session()->regenerate();
            $user = Auth::user();

            // Redirect based on role
            return match ($user->role) {
                'student' => redirect()->route('student.dashboard'),
                'staff' => redirect()->route('staff.dashboard'),
                'admin' => redirect()->route('admin.dashboard'),
                default => redirect()->route('dashboard'),
            };
        }

        // If login failed → count failed attempt
        \Illuminate\Support\Facades\RateLimiter::hit($key, 60); // lockout for 60 seconds
        return back()->withErrors(['password' => 'Incorrect password.'])->onlyInput('email');
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('status', 'You have been logged out.');
    }
}
