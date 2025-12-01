<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class VerifyUserEmail extends Command
{
    protected $signature = 'user:verify-email {email?}';
    protected $description = 'Manually verify a user email address';

    public function handle()
    {
        $email = $this->argument('email');

        if (!$email) {
            $email = $this->ask('Enter email address to verify');
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("User not found: {$email}");
            return 1;
        }

        if ($user->email_verified_at) {
            $this->info("Email already verified: {$email}");
            return 0;
        }

        $user->email_verified_at = now();
        $user->save();

        $this->info("✓ Email verified successfully: {$email}");
        $this->line("User can now login.");

        return 0;
    }
}
