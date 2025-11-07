<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('grievances') && Schema::hasColumn('grievances', 'filed_by_staff_id')) {
            Schema::table('grievances', function (Blueprint $table) {
                // Drop foreign key if exists (MySQL naming convention used earlier)
                try {
                    $table->dropForeign(['filed_by_staff_id']);
                } catch (\Exception $e) {
                    // ignore if already dropped or named differently
                }

                // Also drop the column to fully decouple
                if (Schema::hasColumn('grievances', 'filed_by_staff_id')) {
                    $table->dropColumn('filed_by_staff_id');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('grievances') && !Schema::hasColumn('grievances', 'filed_by_staff_id')) {
            Schema::table('grievances', function (Blueprint $table) {
                $table->unsignedBigInteger('filed_by_staff_id')->nullable()->after('student_id');
                $table->foreign('filed_by_staff_id')->references('id')->on('staff')->onDelete('set null');
            });
        }
    }
};
