<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateStaffTableProfilePhoto extends Migration
{
    public function up(): void
    {
        Schema::table('staff', function (Blueprint $table) {
            // 1️⃣ Drop the old 'avatar' column if it exists
            if (Schema::hasColumn('staff', 'avatar')) {
                $table->dropColumn('avatar');
            }

            // 2️⃣ Rename 'profile_photo' → 'profile_photo_path'
            if (Schema::hasColumn('staff', 'profile_photo')) {
                $table->renameColumn('profile_photo', 'profile_photo_path');
            }
        });
    }

    public function down(): void
    {
        Schema::table('staff', function (Blueprint $table) {
            // Reverse changes in case of rollback
            $table->string('avatar')->nullable();
            if (Schema::hasColumn('staff', 'profile_photo_path')) {
                $table->renameColumn('profile_photo_path', 'profile_photo');
            }
        });
    }
}
