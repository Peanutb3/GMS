<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update good_moral_requests status enum to use 'processing' instead of 'approved' and 'rejected'
        DB::statement("ALTER TABLE `good_moral_requests` MODIFY COLUMN `status` ENUM('pending', 'processing', 'completed') NOT NULL DEFAULT 'pending'");

        // Update safe_loan_requests status enum to use 'processing' instead of 'approved' and 'rejected'
        DB::statement("ALTER TABLE `safe_loan_requests` MODIFY COLUMN `status` ENUM('pending', 'processing', 'completed') NOT NULL DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert good_moral_requests status enum back to previous values
        DB::statement("ALTER TABLE `good_moral_requests` MODIFY COLUMN `status` ENUM('pending', 'approved', 'rejected', 'completed') NOT NULL DEFAULT 'pending'");

        // Revert safe_loan_requests status enum back to previous values
        DB::statement("ALTER TABLE `safe_loan_requests` MODIFY COLUMN `status` ENUM('pending', 'approved', 'rejected', 'completed') NOT NULL DEFAULT 'pending'");
    }
};
