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
        // Update the role enum to include new OSAS roles
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'staff', 'student', 'osas_gmc', 'osas_du') NOT NULL DEFAULT 'student'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original roles
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'staff', 'student') NOT NULL DEFAULT 'student'");
    }
};
