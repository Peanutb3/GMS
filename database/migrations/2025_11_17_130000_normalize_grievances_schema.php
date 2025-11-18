<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('grievances')) {
            return;
        }

        Schema::table('grievances', function (Blueprint $table) {
            // Add student_record_id -> students(id)
            if (!Schema::hasColumn('grievances', 'student_record_id') && Schema::hasTable('students')) {
                $table->foreignId('student_record_id')->nullable()->after('student_id')->constrained('students')->nullOnDelete();
            }

            // Ensure filed_by_staff_id exists when staff table present
            if (Schema::hasTable('staff') && !Schema::hasColumn('grievances', 'filed_by_staff_id')) {
                $table->unsignedBigInteger('filed_by_staff_id')->nullable()->after('student_record_id');
            }
        });

        // Add FK for filed_by_staff_id if both table/column exist (avoid errors if previously added)
        if (Schema::hasTable('staff') && Schema::hasColumn('grievances', 'filed_by_staff_id')) {
            try {
                Schema::table('grievances', function (Blueprint $table) {
                    $table->foreign('filed_by_staff_id')->references('id')->on('staff')->nullOnDelete();
                });
            } catch (\Throwable $e) {
                // ignore if FK already exists
            }
        }

        // Backfill student_record_id from student_id (string) where possible
        if (Schema::hasColumn('grievances', 'student_record_id') && Schema::hasColumn('grievances', 'student_id')) {
            try {
                // SQLite-compatible backfill using app-level iteration
                $pairs = DB::table('grievances')
                    ->select('grievances.id as gid', 'students.id as sid')
                    ->join('students', 'students.student_id', '=', 'grievances.student_id')
                    ->whereNull('grievances.student_record_id')
                    ->get();
                foreach ($pairs as $p) {
                    DB::table('grievances')->where('id', $p->gid)->update(['student_record_id' => $p->sid]);
                }
            } catch (\Throwable $e) {
                // ignore backfill failures; proceed
            }
        }

        // Align status values: map 'Open' to 'pending'
        if (Schema::hasColumn('grievances', 'status')) {
            DB::table('grievances')->where('status', 'Open')->update(['status' => 'pending']);
        }

        // Add helpful indexes
        Schema::table('grievances', function (Blueprint $table) {
            if (Schema::hasColumn('grievances', 'status')) {
                $table->index('status', 'grievances_status_idx');
            }
            if (Schema::hasColumn('grievances', 'student_record_id')) {
                $table->index('student_record_id', 'grievances_student_record_idx');
            }
            if (Schema::hasColumn('grievances', 'filed_by_staff_id')) {
                $table->index('filed_by_staff_id', 'grievances_filed_by_staff_idx');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('grievances')) {
            return;
        }
        Schema::table('grievances', function (Blueprint $table) {
            // Drop added indexes
            try { $table->dropIndex('grievances_status_idx'); } catch (\Throwable $e) {}
            try { $table->dropIndex('grievances_student_record_idx'); } catch (\Throwable $e) {}
            try { $table->dropIndex('grievances_filed_by_staff_idx'); } catch (\Throwable $e) {}

            // Drop FK columns added by this migration only
            if (Schema::hasColumn('grievances', 'student_record_id')) {
                try { $table->dropForeign(['student_record_id']); } catch (\Throwable $e) {}
                $table->dropColumn('student_record_id');
            }

            if (Schema::hasColumn('grievances', 'filed_by_staff_id')) {
                try { $table->dropForeign(['filed_by_staff_id']); } catch (\Throwable $e) {}
                // Don't drop column on down to avoid removing existing data unexpectedly
            }
        });
    }
};