<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->id();

            // Relation to users table
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');

            // Staff details
            $table->string('employee_id')->unique();
            $table->string('first_name');
            $table->string('middle_initial')->nullable();
            $table->string('last_name');
            $table->string('suffix')->nullable();

            $table->string('department')->nullable();
            $table->string('position')->nullable();
            $table->string('role')->default('staff');
            $table->string('phone')->nullable();
            $table->string('email')->unique()->nullable();

            // ✅ Unified profile photo field
            $table->string('profile_photo_path')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
