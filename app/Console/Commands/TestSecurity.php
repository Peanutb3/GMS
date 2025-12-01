<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TestSecurity extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:security {action?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test security features';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $action = $this->argument('action');

        if (!$action) {
            $this->showMenu();
            return;
        }

        switch ($action) {
            case 'password':
                $this->testPasswordValidation();
                break;
            case 'lockout':
                $this->testAccountLockout();
                break;
            case 'unlock':
                $this->unlockAccount();
                break;
            case 'headers':
                $this->testSecurityHeaders();
                break;
            default:
                $this->error("Unknown action: {$action}");
                $this->showMenu();
        }
    }

    private function showMenu()
    {
        $this->info('Security Testing Commands:');
        $this->line('');
        $this->line('  php artisan test:security password  - Test password validation');
        $this->line('  php artisan test:security lockout   - Check locked accounts');
        $this->line('  php artisan test:security unlock    - Unlock an account');
        $this->line('  php artisan test:security headers   - Show security headers info');
    }

    private function testPasswordValidation()
    {
        $this->info('Testing Password Validation Rules');
        $this->line('');

        $tests = [
            'password' => false,
            'Password' => false,
            'Password1' => false,
            'Password!' => false,
            'Pass123!' => false,
            'Welcome123!' => true,
            'School@2025' => true,
            'Test' => false,
        ];

        foreach ($tests as $password => $shouldPass) {
            $rules = [
                'length' => strlen($password) >= 8,
                'lowercase' => preg_match('/[a-z]/', $password),
                'uppercase' => preg_match('/[A-Z]/', $password),
                'number' => preg_match('/[0-9]/', $password),
                'special' => preg_match('/[@$!%*#?&]/', $password),
            ];

            $passes = array_sum($rules) === 5;
            $expected = $shouldPass ? '✓' : '✗';
            $actual = $passes ? '✓' : '✗';
            $status = ($passes === $shouldPass) ? '<info>PASS</info>' : '<error>FAIL</error>';

            $this->line("Password: <comment>{$password}</comment> (expected: {$expected}, actual: {$actual}) - {$status}");

            if (!$passes) {
                $failedRules = array_filter($rules, fn($v) => !$v);
                $this->line('  Failed: ' . implode(', ', array_keys($failedRules)));
            }
        }
    }

    private function testAccountLockout()
    {
        $this->info('Checking Locked Accounts');
        $this->line('');

        $locked = User::whereNotNull('locked_until')
            ->where('locked_until', '>', now())
            ->get();

        if ($locked->isEmpty()) {
            $this->info('No accounts are currently locked.');
            return;
        }

        $this->table(
            ['ID', 'Email', 'Role', 'Locked Until', 'Minutes Remaining'],
            $locked->map(fn($user) => [
                $user->id,
                $user->email,
                $user->role,
                $user->locked_until->format('Y-m-d H:i:s'),
                now()->diffInMinutes($user->locked_until, false)
            ])
        );
    }

    private function unlockAccount()
    {
        $email = $this->ask('Enter email address to unlock');

        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("User not found: {$email}");
            return;
        }

        if (!$user->locked_until) {
            $this->info("Account is not locked: {$email}");
            return;
        }

        $user->update(['locked_until' => null]);
        $this->info("Account unlocked successfully: {$email}");
    }

    private function testSecurityHeaders()
    {
        $this->info('Security Headers Configuration');
        $this->line('');

        $headers = [
            'X-Frame-Options' => 'SAMEORIGIN',
            'X-Content-Type-Options' => 'nosniff',
            'X-XSS-Protection' => '1; mode=block',
            'Referrer-Policy' => 'strict-origin-when-cross-origin',
            'Permissions-Policy' => 'geolocation=(), microphone=(), camera=()',
        ];

        $this->table(
            ['Header', 'Value'],
            collect($headers)->map(fn($value, $header) => [$header, $value])
        );

        $this->line('');
        $this->info('Middleware: App\Http\Middleware\SecurityHeaders');
        $this->line('Registered: bootstrap/app.php');
        $this->line('');
        $this->comment('To test in browser:');
        $this->line('1. Open DevTools → Network tab');
        $this->line('2. Reload page');
        $this->line('3. Click any request → Response Headers');
        $this->line('');
        $this->comment('Or test online:');
        $this->line('https://securityheaders.com/ (after deployment)');
    }
}
