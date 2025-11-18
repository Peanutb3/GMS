<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('good_moral_requests') && !Schema::hasColumn('good_moral_requests','student_id')) {
            Schema::table('good_moral_requests', function (Blueprint $table) {
                $table->foreignId('student_id')->nullable()->after('id')->constrained('students')->cascadeOnUpdate()->nullOnDelete();
            });
        }
        if (Schema::hasTable('safe_loan_requests') && !Schema::hasColumn('safe_loan_requests','student_id')) {
            Schema::table('safe_loan_requests', function (Blueprint $table) {
                $table->foreignId('student_id')->nullable()->after('id')->constrained('students')->cascadeOnUpdate()->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('good_moral_requests') && Schema::hasColumn('good_moral_requests','student_id')) {
            Schema::table('good_moral_requests', function (Blueprint $table) {
                $table->dropForeign(['student_id']);
                $table->dropColumn('student_id');
            });
        }
        if (Schema::hasTable('safe_loan_requests') && Schema::hasColumn('safe_loan_requests','student_id')) {
            Schema::table('safe_loan_requests', function (Blueprint $table) {
                $table->dropForeign(['student_id']);
                $table->dropColumn('student_id');
            });
        }
    }
};
