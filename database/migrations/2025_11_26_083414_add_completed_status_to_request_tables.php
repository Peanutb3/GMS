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
        // Add 'completed' to good_moral_requests status enum
        DB::statement("ALTER TABLE `good_moral_requests` MODIFY COLUMN `status` ENUM('pending', 'approved', 'rejected', 'completed') NOT NULL DEFAULT 'pending'");

        // Add 'completed' to safe_loan_requests status enum
        DB::statement("ALTER TABLE `safe_loan_requests` MODIFY COLUMN `status` ENUM('pending', 'approved', 'rejected', 'completed') NOT NULL DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove 'completed' from good_moral_requests status enum
        DB::statement("ALTER TABLE `good_moral_requests` MODIFY COLUMN `status` ENUM('pending', 'approved', 'rejected') NOT NULL DEFAULT 'pending'");

        // Remove 'completed' from safe_loan_requests status enum
        DB::statement("ALTER TABLE `safe_loan_requests` MODIFY COLUMN `status` ENUM('pending', 'approved', 'rejected') NOT NULL DEFAULT 'pending'");
    }
};
