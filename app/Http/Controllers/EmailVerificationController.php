<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;

class EmailVerificationController extends Controller
{
    /**
     * Display the email verification notice.
     */
    public function notice()
    {
        if (Auth::user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard');
        }

        return view('auth.verify-email');
    }

    /**
     * Handle email verification.
     */
    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return redirect()->route('login')->with('success', 'Email verified successfully! You can now login.');
    }

    /**
     * Resend the email verification notification.
     */
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('success', 'Verification link sent! Please check your email.');
    }
}
