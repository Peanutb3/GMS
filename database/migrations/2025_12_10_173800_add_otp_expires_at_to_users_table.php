<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // OTP expiration - role-based:
            // Admin: 1 month, Staff: new device only, Students: new device only
            $table->timestamp('otp_expires_at')->nullable()->after('two_factor_verified_at');

            // Track trusted devices to avoid repeated OTP
            $table->text('trusted_devices')->nullable()->after('otp_expires_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['otp_expires_at', 'trusted_devices']);
        });
    }
};
