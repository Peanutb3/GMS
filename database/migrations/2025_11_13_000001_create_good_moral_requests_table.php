<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('good_moral_requests', function (Blueprint $table) {
            $table->id();
            $table->date('date_needed')->nullable();
            $table->string('email')->nullable();
            $table->string('contact')->nullable();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->enum('gender', ['Female', 'Male', 'Prefer not to say'])->nullable();
            $table->string('program_year')->nullable(); // e.g., BSIT - 3rd Year
            $table->enum('student_status', ['currently_enrolled', 'not_enrolled'])->nullable();
            $table->string('last_semester')->nullable(); // for not enrolled
            $table->string('year_graduated')->nullable();
            $table->text('purpose')->nullable();
            $table->unsignedInteger('copies')->default(1);
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('good_moral_requests');
    }
};
