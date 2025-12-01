<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class AdminSettingsController extends Controller
{
    public function index()
    {
        // In a real app, these would come from a settings table or config
        $settings = [
            'school_name' => config('app.school_name', 'School Name'),
            'current_semester' => config('app.current_semester', '1st Semester'),
            'current_year' => config('app.current_year', date('Y')),
            'osas_head' => config('app.osas_head', 'OSAS Head Name'),
            'contact_email' => config('app.contact_email', 'osas@school.edu'),
            'contact_phone' => config('app.contact_phone', ''),
        ];

        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'school_name' => 'required|string|max:255',
            'current_semester' => 'required|string|max:100',
            'current_year' => 'required|string|max:10',
            'osas_head' => 'required|string|max:255',
            'contact_email' => 'required|email',
            'contact_phone' => 'nullable|string|max:20',
            'signature' => 'nullable|image|max:2048',
        ]);

        // In a real app, you'd save these to a database settings table
        // For now, we'll just return success
        // You could also update .env file or a dedicated settings table

        if ($request->hasFile('signature')) {
            $path = $request->file('signature')->store('signatures', 'public');
            // Save path to settings
        }

        return redirect()->route('admin.settings')
            ->with('success', 'Settings updated successfully');
    }

    public function testEmail(Request $request)
    {
        $request->validate([
            'test_email' => 'required|email'
        ]);

        try {
            Mail::raw('This is a test email from the Grievance Management System. If you received this, your email configuration is working correctly!', function ($message) use ($request) {
                $message->to($request->test_email)
                    ->subject('GMS - Test Email');
            });

            return back()->with('success', 'Test email sent successfully! Check ' . $request->test_email);
        } catch (\Exception $e) {
            Log::error('Email test failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to send test email: ' . $e->getMessage());
        }
    }
}
