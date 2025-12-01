<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Student;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Crypt;

class TestAdvancedSecurity extends Command
{
    protected $signature = 'test:advanced-security {feature?}';
    protected $description = 'Test advanced security features';

    public function handle()
    {
        $feature = $this->argument('feature');

        if (!$feature) {
            $this->showMenu();
            return;
        }

        switch ($feature) {
            case 'email':
                $this->testEmailVerification();
                break;
            case 'audit':
                $this->testAuditLogging();
                break;
            case 'encryption':
                $this->testEncryption();
                break;
            case 'all':
                $this->testAll();
                break;
            default:
                $this->error("Unknown feature: {$feature}");
                $this->showMenu();
        }
    }

    private function showMenu()
    {
        $this->info('Advanced Security Testing Commands:');
        $this->line('');
        $this->line('  php artisan test:advanced-security email      - Test email verification');
        $this->line('  php artisan test:advanced-security audit      - Test audit logging');
        $this->line('  php artisan test:advanced-security encryption - Test encryption');
        $this->line('  php artisan test:advanced-security all        - Test everything');
    }

    private function testEmailVerification()
    {
        $this->info('Testing Email Verification System');
        $this->line('');

        // Check unverified users
        $unverified = User::whereNull('email_verified_at')->count();
        $verified = User::whereNotNull('email_verified_at')->count();

        $this->table(
            ['Status', 'Count'],
            [
                ['Unverified', $unverified],
                ['Verified', $verified],
                ['Total', $unverified + $verified],
            ]
        );

        if ($unverified > 0) {
            $this->warn("You have {$unverified} unverified users.");
            $this->line('');
            $this->comment('Unverified users:');
            User::whereNull('email_verified_at')->each(function ($user) {
                $this->line("  - {$user->email} (ID: {$user->id})");
            });
        } else {
            $this->info('All users are verified! ✓');
        }

        $this->line('');
        $this->comment('Email Verification Routes:');
        $this->line('  GET  /email/verify');
        $this->line('  GET  /email/verify/{id}/{hash}');
        $this->line('  POST /email/resend');
    }

    private function testAuditLogging()
    {
        $this->info('Testing Audit Logging System');
        $this->line('');

        $totalLogs = AuditLog::count();
        $recentLogs = AuditLog::where('created_at', '>', now()->subDay())->count();

        $this->table(
            ['Metric', 'Value'],
            [
                ['Total Audit Logs', number_format($totalLogs)],
                ['Last 24 Hours', number_format($recentLogs)],
            ]
        );

        $this->line('');
        $this->comment('Recent Actions (last 10):');

        $recent = AuditLog::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        if ($recent->isEmpty()) {
            $this->warn('No audit logs found.');
        } else {
            $this->table(
                ['Time', 'User', 'Action', 'Status'],
                $recent->map(fn($log) => [
                    $log->created_at->format('Y-m-d H:i:s'),
                    optional($log->user)->email ?? 'System',
                    $log->action,
                    $log->status ?? 'N/A',
                ])
            );
        }

        $this->line('');
        $this->comment('New Audit Log Fields:');
        $this->line('  ✓ user_agent     - Browser & OS info');
        $this->line('  ✓ request_method - HTTP method (GET/POST/etc)');
        $this->line('  ✓ request_url    - Full URL');
        $this->line('  ✓ description    - Human-readable description');
        $this->line('  ✓ status         - success/failed/error');
    }

    private function testEncryption()
    {
        $this->info('Testing Database Encryption');
        $this->line('');

        $totalStudents = Student::count();
        $encrypted = 0;
        $unencrypted = 0;

        $this->comment('Checking student records...');
        $students = Student::all();

        foreach ($students as $student) {
            if ($student->student_id) {
                try {
                    // Try to decrypt - if it works, it's encrypted
                    Crypt::decryptString($student->student_id);
                    $encrypted++;
                } catch (\Exception $e) {
                    $unencrypted++;
                }
            }
        }

        $this->table(
            ['Status', 'Count'],
            [
                ['Total Students', $totalStudents],
                ['Encrypted', $encrypted],
                ['Unencrypted', $unencrypted],
            ]
        );

        if ($unencrypted > 0) {
            $this->warn("You have {$unencrypted} unencrypted student records!");
            $this->line('');
            $this->comment('Run this to encrypt existing data:');
            $this->line('  php artisan encrypt:data Student');
        } else {
            $this->info('All student data is encrypted! ✓');
        }

        $this->line('');
        $this->comment('Encrypted Fields:');
        $this->line('  - student_id');
        $this->line('  - phone');

        $this->line('');
        $this->comment('⚠️  IMPORTANT: Backup your APP_KEY!');
        $this->warn('Without it, encrypted data cannot be recovered.');
    }

    private function testAll()
    {
        $this->testEmailVerification();
        $this->line('');
        $this->line(str_repeat('=', 60));
        $this->line('');

        $this->testAuditLogging();
        $this->line('');
        $this->line(str_repeat('=', 60));
        $this->line('');

        $this->testEncryption();
    }
}
