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
use App\Models\AuditLog;

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
            'account_type'   => 'required|in:student',
            // Student-specific
            'student_id'     => 'required|unique:students,student_id',
            'college'        => 'required',
            'program'        => 'required',
            'year'           => 'required',
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

        // Create user with student role
        $user = User::create([
            'name' => $step1['first_name'].' '.$step1['last_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role' => 'student',
        ]);

        // Create student record
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
            'osas_gmc' => redirect()->route('osas-gmc.dashboard'),
            'osas_du' => redirect()->route('osas-du.dashboard'),
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
            // log rate-limited attempt (if we can resolve a user id)
            AuditLog::create([
                'auditable_type' => User::class,
                'auditable_id'   => $user?->id ?? 0,
                'action'         => 'login_rate_limited',
                'user_id'        => $user?->id,
                'staff_id'       => optional(optional($user)->staff)->id,
                'old_values'     => null,
                'new_values'     => ['email' => $request->email],
                'ip_address'     => $request->ip(),
            ]);
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

            // log successful login
            AuditLog::create([
                'auditable_type' => User::class,
                'auditable_id'   => $user->id,
                'action'         => 'login',
                'user_id'        => $user->id,
                'staff_id'       => optional($user->staff)->id,
                'old_values'     => null,
                'new_values'     => ['remember' => $remember],
                'ip_address'     => $request->ip(),
            ]);

            // Redirect based on role
            return match ($user->role) {
                'student' => redirect()->route('student.dashboard'),
                'staff' => redirect()->route('staff.dashboard'),
                'osas_gmc' => redirect()->route('osas-gmc.dashboard'),
                'osas_du' => redirect()->route('osas-du.dashboard'),
                'admin' => redirect()->route('admin.dashboard'),
                default => redirect()->route('dashboard'),
            };
        }

        // If login failed → count failed attempt
        \Illuminate\Support\Facades\RateLimiter::hit($key, 60); // lockout for 60 seconds
        // log failed login attempt
        AuditLog::create([
            'auditable_type' => User::class,
            'auditable_id'   => $user?->id ?? 0,
            'action'         => 'login_failed',
            'user_id'        => $user?->id,
            'staff_id'       => optional(optional($user)->staff)->id,
            'old_values'     => null,
            'new_values'     => ['email' => $request->email],
            'ip_address'     => $request->ip(),
        ]);
        return back()->withErrors(['password' => 'Incorrect password.'])->onlyInput('email');
    }


    public function logout(Request $request)
    {
        $user = $request->user();
        // log before session is cleared
        if ($user) {
            AuditLog::create([
                'auditable_type' => User::class,
                'auditable_id'   => $user->id,
                'action'         => 'logout',
                'user_id'        => $user->id,
                'staff_id'       => optional($user->staff)->id,
                'old_values'     => null,
                'new_values'     => null,
                'ip_address'     => $request->ip(),
            ]);
        }
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('status', 'You have been logged out.');
    }
}
