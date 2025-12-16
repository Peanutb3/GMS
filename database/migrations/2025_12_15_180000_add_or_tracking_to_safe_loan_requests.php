<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('safe_loan_requests', function (Blueprint $table) {
            // Add columns similar to good_moral_requests for consistency
            if (!Schema::hasColumn('safe_loan_requests', 'or_number')) {
                $table->string('or_number')->nullable()->after('status');
            }
            if (!Schema::hasColumn('safe_loan_requests', 'or_entered_at')) {
                $table->timestamp('or_entered_at')->nullable()->after('or_number');
            }
            if (!Schema::hasColumn('safe_loan_requests', 'completed_at')) {
                $table->timestamp('completed_at')->nullable()->after('or_entered_at');
            }
            // Add student_id and staff_id if not exists
            if (!Schema::hasColumn('safe_loan_requests', 'student_id')) {
                $table->unsignedBigInteger('student_id')->nullable()->after('id');
                $table->foreign('student_id')->references('id')->on('students')->onDelete('set null');
            }
            if (!Schema::hasColumn('safe_loan_requests', 'staff_id')) {
                $table->unsignedBigInteger('staff_id')->nullable()->after('student_id');
                $table->foreign('staff_id')->references('id')->on('staff')->onDelete('set null');
            }
            if (!Schema::hasColumn('safe_loan_requests', 'reference_no')) {
                $table->string('reference_no')->nullable()->unique()->after('staff_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('safe_loan_requests', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
            $table->dropForeign(['staff_id']);
            $table->dropColumn(['student_id', 'staff_id', 'reference_no', 'or_number', 'or_entered_at', 'completed_at']);
        });
    }
};
