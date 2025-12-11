<?php

namespace App\Http\Controllers;

use App\Models\TwoFactorCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class TwoFactorController extends Controller
{
    public function show()
    {
        if (!session('2fa:user:id')) {
            return redirect()->route('login');
        }

        return view('auth.two-factor');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6',
        ]);

        $userId = session('2fa:user:id');
        $deviceFingerprint = session('2fa:device:fingerprint');

        if (!$userId) {
            return redirect()->route('login')->withErrors(['error' => 'Session expired. Please login again.']);
        }

        $twoFactorCode = TwoFactorCode::where('user_id', $userId)
            ->where('code', $request->code)
            ->whereNull('verified_at')
            ->latest()
            ->first();

        if (!$twoFactorCode) {
            return back()->withErrors(['code' => 'Invalid verification code.']);
        }

        if ($twoFactorCode->isExpired()) {
            return back()->withErrors(['code' => 'Verification code has expired.']);
        }

        // Mark code as verified
        $twoFactorCode->update(['verified_at' => now()]);

        // Get user and set OTP expiration based on role
        $user = \App\Models\User::find($userId);
        if ($user) {
            // Set OTP expiration:
            // - Admin: 1 month
            // - Staff/Students: indefinite (only triggers on new device)
            $user->setOtpExpiration();

            // Trust this device if fingerprint is available
            if ($deviceFingerprint) {
                $user->trustDevice($deviceFingerprint);
            }
        }

        // Log the user in
        Auth::loginUsingId($userId);

        // Clear session
        session()->forget(['2fa:user:id', '2fa:device:fingerprint', '2fa:test:code']);

        // Redirect by role to ensure required view data exists
        $user = Auth::user();
        return match ($user->role) {
            'student' => redirect()->route('student.dashboard'),
            'staff' => redirect()->route('staff.dashboard'),
            'osas_gmc' => redirect()->route('osas-gmc.dashboard'),
            'osas_du' => redirect()->route('osas-du.dashboard'),
            'admin' => redirect()->route('admin.dashboard'),
            default => redirect()->route('dashboard'),
        };
    }

    public function resend()
    {
        $userId = session('2fa:user:id');

        if (!$userId) {
            return redirect()->route('login')->withErrors(['error' => 'Session expired. Please login again.']);
        }

        $user = \App\Models\User::find($userId);

        // Generate new code
        $code = TwoFactorCode::generateCode();

        // Delete old codes
        TwoFactorCode::where('user_id', $userId)
            ->whereNull('verified_at')
            ->delete();

        // Create new code
        TwoFactorCode::create([
            'user_id' => $userId,
            'code' => $code,
            'expires_at' => Carbon::now()->addMinutes(10),
        ]);

        // Try to send email; continue even if it fails (dev mode)
        try {
            Mail::send('emails.two-factor-code', ['code' => $code, 'user' => $user], function ($message) use ($user) {
                $message->to($user->email);
                $message->subject('Your Verification Code - OSAS GMS');
            });
        } catch (\Exception $e) {
            \Log::error('2FA resend email failed: ' . $e->getMessage());
        }

        // Store OTP in session for testing (displayed in view)
        session(['2fa:test:code' => $code]);

        return back()->with('success', 'A new verification code has been generated. Check the code box.');
    }
}
