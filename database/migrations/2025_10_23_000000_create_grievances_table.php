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
        if (!Schema::hasTable('grievances')) {
            Schema::create('grievances', function (Blueprint $table) {
                $table->id();
                $table->string('case_id')->unique();

                // Link to student (by student_id string)
                $table->string('student_id')->nullable();

                // Link to staff
                $table->unsignedBigInteger('filed_by_staff_id')->nullable();
                $table->foreign('filed_by_staff_id')
                      ->references('id')
                      ->on('staff')
                      ->onDelete('set null');

                // Student info snapshot
                $table->string('name');
                $table->string('program')->nullable();

                // Grievance details
                $table->date('date')->nullable();
                $table->string('grievance');
                $table->text('description')->nullable();

                // Status & metadata
                $table->string('status')->default('Open');
                $table->string('filed_by')->nullable(); // keeps readable staff name

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grievances');
    }
};
