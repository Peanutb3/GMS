<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('grievances', function (Blueprint $table) {
            // Rename name → name_snapshot
            if (Schema::hasColumn('grievances', 'name') && !Schema::hasColumn('grievances', 'name_snapshot')) {
                $table->renameColumn('name', 'name_snapshot');
            }
            // Rename program → program_snapshot
            if (Schema::hasColumn('grievances', 'program') && !Schema::hasColumn('grievances', 'program_snapshot')) {
                $table->renameColumn('program', 'program_snapshot');
            }
            // filed_by → filed_by_name_snapshot
            if (Schema::hasColumn('grievances', 'filed_by') && !Schema::hasColumn('grievances', 'filed_by_name_snapshot')) {
                $table->renameColumn('filed_by', 'filed_by_name_snapshot');
            }
            // Add gender_snapshot if missing
            if (!Schema::hasColumn('grievances', 'gender_snapshot')) {
                $table->string('gender_snapshot', 32)->nullable()->after('program_snapshot');
            }
            // Add student_no_snapshot if missing (string copy of student number)
            if (!Schema::hasColumn('grievances', 'student_no_snapshot')) {
                $table->string('student_no_snapshot', 64)->nullable()->after('student_record_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('grievances', function (Blueprint $table) {
            if (Schema::hasColumn('grievances', 'name_snapshot') && !Schema::hasColumn('grievances', 'name')) {
                $table->renameColumn('name_snapshot', 'name');
            }
            if (Schema::hasColumn('grievances', 'program_snapshot') && !Schema::hasColumn('grievances', 'program')) {
                $table->renameColumn('program_snapshot', 'program');
            }
            if (Schema::hasColumn('grievances', 'filed_by_name_snapshot') && !Schema::hasColumn('grievances', 'filed_by')) {
                $table->renameColumn('filed_by_name_snapshot', 'filed_by');
            }
            if (Schema::hasColumn('grievances', 'gender_snapshot')) {
                $table->dropColumn('gender_snapshot');
            }
            if (Schema::hasColumn('grievances', 'student_no_snapshot')) {
                $table->dropColumn('student_no_snapshot');
            }
        });
    }
};