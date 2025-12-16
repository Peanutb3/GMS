<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('safe_loan_requests', function (Blueprint $table) {
            // Drop the combined program_year field
            if (Schema::hasColumn('safe_loan_requests', 'program_year')) {
                $table->dropColumn('program_year');
            }

            // Add separate fields to match Good Moral structure
            if (!Schema::hasColumn('safe_loan_requests', 'college')) {
                $table->string('college')->nullable()->after('gender');
            }
            if (!Schema::hasColumn('safe_loan_requests', 'program')) {
                $table->string('program')->nullable()->after('college');
            }
            if (!Schema::hasColumn('safe_loan_requests', 'year')) {
                $table->string('year')->nullable()->after('program');
            }
            if (!Schema::hasColumn('safe_loan_requests', 'from_sy')) {
                $table->string('from_sy')->nullable()->after('last_semester');
            }
            if (!Schema::hasColumn('safe_loan_requests', 'to_sy')) {
                $table->string('to_sy')->nullable()->after('from_sy');
            }
        });
    }

    public function down(): void
    {
        Schema::table('safe_loan_requests', function (Blueprint $table) {
            // Restore program_year field
            if (!Schema::hasColumn('safe_loan_requests', 'program_year')) {
                $table->string('program_year')->nullable()->after('gender');
            }

            // Drop the new separate fields
            if (Schema::hasColumn('safe_loan_requests', 'to_sy')) {
                $table->dropColumn('to_sy');
            }
            if (Schema::hasColumn('safe_loan_requests', 'from_sy')) {
                $table->dropColumn('from_sy');
            }
            if (Schema::hasColumn('safe_loan_requests', 'year')) {
                $table->dropColumn('year');
            }
            if (Schema::hasColumn('safe_loan_requests', 'program')) {
                $table->dropColumn('program');
            }
            if (Schema::hasColumn('safe_loan_requests', 'college')) {
                $table->dropColumn('college');
            }
        });
    }
};
