<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use App\Models\Staff;
use App\Models\College;
use App\Models\DeviceFingerprint;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

class AuthController extends Controller
{
    /**
     * ---------------------------
     * MULTI-STEP SIGNUP
     * ---------------------------
     */
    public function showStep1()
    {
        $colleges = College::active()->orderBy('name')->get();
        return view('signup-step1', compact('colleges'));
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
            'phone'          => 'nullable|string|max:11',
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
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&_\-]/'
            ],
        ], [
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
        ]);

        // Create user with student role
        $user = User::create([
            'name' => $step1['first_name'] . ' ' . $step1['last_name'],
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
            'phone'          => $step1['phone'] ?? null,
        ]);

        session()->forget('signup_step1');

        // Send email verification notification
        $user->sendEmailVerificationNotification();

        return redirect()->route('login')
            ->with('success', 'Account created! Please check your email to verify your account before logging in.');
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

        // Email verification is no longer required for any role (2FA is sufficient)

        // Check if account is locked
        if ($user->locked_until && now()->lt($user->locked_until)) {
            $minutes = now()->diffInMinutes($user->locked_until);
            return back()->withErrors([
                'password' => "Account locked due to multiple failed login attempts. Try again in {$minutes} minutes."
            ])->onlyInput('email');
        }

        // Setup rate limiter key
        $key = \Illuminate\Support\Str::lower($request->email) . '|' . $request->ip();

        // Check if too many attempts
        if (\Illuminate\Support\Facades\RateLimiter::tooManyAttempts($key, 5)) {
            // Lock account for 30 minutes after 5 failed attempts
            $user->update(['locked_until' => now()->addMinutes(30)]);

            AuditLog::create([
                'auditable_type' => User::class,
                'auditable_id'   => $user->id,
                'action'         => 'account_locked',
                'user_id'        => $user->id,
                'staff_id'       => optional($user->staff)->id,
                'old_values'     => null,
                'new_values'     => ['locked_until' => $user->locked_until],
                'ip_address'     => $request->ip(),
            ]);
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
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], false)) { // Don't actually log in yet
            // Clear failed attempts and unlock account
            \Illuminate\Support\Facades\RateLimiter::clear($key);
            $user->update(['locked_until' => null]);

            // Logout immediately (we'll log in after OTP verification)
            Auth::logout();

            // Get device fingerprint using the DeviceFingerprint model method
            $deviceFingerprint = \App\Models\DeviceFingerprint::generateFingerprint(
                $request->userAgent() ?? 'Unknown',
                $request->ip() ?? '0.0.0.0'
            );

            // Debug logging
            \Log::info('Login - Device Fingerprint Generated', [
                'user_id' => $user->id,
                'email' => $user->email,
                'fingerprint' => $deviceFingerprint,
                'user_agent' => $request->userAgent(),
                'ip' => $request->ip()
            ]);

            // Check if 2FA is enabled and required based on role and device
            $requiresOtp = false;
            if ($user->two_factor_enabled) {
                $requiresOtp = $user->requiresOtp($deviceFingerprint);

                // Debug logging
                \Log::info('Login - OTP Check', [
                    'user_id' => $user->id,
                    'requires_otp' => $requiresOtp,
                    'otp_expires_at' => $user->otp_expires_at,
                    'is_trusted_device' => $user->isTrustedDevice($deviceFingerprint)
                ]);
            }

            if ($requiresOtp) {
                // Generate OTP code
                $code = \App\Models\TwoFactorCode::generateCode();

                // Delete old unverified codes
                \App\Models\TwoFactorCode::where('user_id', $user->id)
                    ->whereNull('verified_at')
                    ->delete();

                // Create new code
                \App\Models\TwoFactorCode::create([
                    'user_id' => $user->id,
                    'code' => $code,
                    'expires_at' => \Carbon\Carbon::now()->addMinutes(10),
                ]);

                // Send email with OTP
                try {
                    \Illuminate\Support\Facades\Mail::send('emails.two-factor-code', ['code' => $code, 'user' => $user], function ($message) use ($user) {
                        $message->to($user->email);
                        $message->subject('Your Verification Code - OSAS GMS');
                    });
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Failed to send 2FA email: ' . $e->getMessage());
                }

                // Store user ID, device fingerprint, user agent, and IP in session for OTP verification
                session([
                    '2fa:user:id' => $user->id,
                    '2fa:device:fingerprint' => $deviceFingerprint,
                    '2fa:user:agent' => $request->userAgent() ?? 'Unknown',
                    '2fa:ip:address' => $request->ip() ?? '0.0.0.0',
                ]);

                // Store OTP in session for testing (REMOVE IN PRODUCTION)
                session(['2fa:test:code' => $code]);

                // Redirect to OTP verification page
                return redirect()->route('2fa.show')
                    ->with('success', 'A verification code has been sent to your email.');
            }

            // If 2FA is disabled, log in normally
            $request->session()->regenerate();
            Auth::loginUsingId($user->id);

            // Update last login timestamp
            $user->update(['last_login_at' => now()]);

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

    /**
     * ---------------------------
     * FORGOT PASSWORD
     * ---------------------------
     */
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Check if user exists
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'We could not find a user with that email address.']);
        }

        // Generate 6-digit code
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Delete old codes for this email
        \DB::table('password_reset_codes')->where('email', $request->email)->delete();

        // Store new code
        \DB::table('password_reset_codes')->insert([
            'email' => $request->email,
            'code' => $code,
            'expires_at' => now()->addMinutes(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Send email with code
        \Mail::send('emails.password-reset-code', ['code' => $code], function ($message) use ($request) {
            $message->to($request->email)
                ->subject('Password Reset Code - GMS');
        });

        // Redirect to verification page
        return redirect()->route('password.verify.show')->with('email', $request->email);
    }

    public function showVerifyCodeForm()
    {
        if (!session('email')) {
            return redirect()->route('password.request');
        }
        return view('auth.verify-reset-code');
    }

    public function verifyResetCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|digits:6',
        ]);

        $record = \DB::table('password_reset_codes')
            ->where('email', $request->email)
            ->where('code', $request->code)
            ->where('expires_at', '>', now())
            ->first();

        if (!$record) {
            return back()->withErrors(['code' => 'Invalid or expired verification code.']);
        }

        // Generate token for reset password form
        $token = Str::random(64);

        // Store token temporarily
        session(['reset_token' => $token, 'reset_email' => $request->email]);

        return redirect()->route('password.reset', ['token' => $token, 'email' => $request->email]);
    }

    public function showResetPasswordForm($token)
    {
        return view('auth.reset-password', ['email' => request('email')]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&_\-]/'
            ],
        ], [
            'password.min' => 'Password must be at least 8 characters.',
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character (@$!%*#?&_-).'
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'User not found.']);
        }

        $user->forceFill([
            'password' => Hash::make($request->password)
        ])->setRememberToken(Str::random(60));
        $user->save();
        event(new PasswordReset($user));
        AuditLog::create([
            'auditable_type' => User::class,
            'auditable_id'   => $user->id,
            'action'         => 'password_reset',
            'user_id'        => $user->id,
            'staff_id'       => optional($user->staff)->id,
            'old_values'     => null,
            'new_values'     => null,
            'ip_address'     => $request->ip(),
        ]);

        return redirect()->route('login')->with('status', 'Password reset successful.');
    }
}
