<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('grievances', function (Blueprint $table) {
            if (!Schema::hasColumn('grievances', 'student_record_id')) {
                $table->unsignedBigInteger('student_record_id')->nullable()->after('student_id');
            }
        });

        // Backfill foreign key based on student_id
        DB::statement("
            UPDATE grievances g
            JOIN students s ON s.student_id = g.student_id
            SET g.student_record_id = s.id
        ");

        Schema::table('grievances', function (Blueprint $table) {
            $table->foreign('student_record_id')
                  ->references('id')->on('students')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('grievances', function (Blueprint $table) {
            $table->dropForeign(['student_record_id']);
            $table->dropColumn('student_record_id');
        });
    }
};
