<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('grievances')) {
            Schema::table('grievances', function (Blueprint $table) {
                if (!Schema::hasColumn('grievances', 'case_id')) {
                    $table->string('case_id')->unique()->after('id');
                }
                if (!Schema::hasColumn('grievances', 'student_id')) {
                    $table->string('student_id')->nullable()->after('case_id');
                }
                if (!Schema::hasColumn('grievances', 'name')) {
                    $table->string('name')->after('student_id');
                }
                if (!Schema::hasColumn('grievances', 'program')) {
                    $table->string('program')->nullable()->after('name');
                }
                if (!Schema::hasColumn('grievances', 'date')) {
                    $table->date('date')->nullable()->after('program');
                }
                if (!Schema::hasColumn('grievances', 'grievance')) {
                    $table->string('grievance')->after('date');
                }
                if (!Schema::hasColumn('grievances', 'description')) {
                    $table->text('description')->nullable()->after('grievance');
                }
                if (!Schema::hasColumn('grievances', 'status')) {
                    $table->string('status')->default('Open')->after('description');
                }
                if (!Schema::hasColumn('grievances', 'filed_by')) {
                    $table->string('filed_by')->nullable()->after('status');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('grievances')) {
            Schema::table('grievances', function (Blueprint $table) {
                if (Schema::hasColumn('grievances', 'filed_by')) {
                    $table->dropColumn('filed_by');
                }
                if (Schema::hasColumn('grievances', 'status')) {
                    $table->dropColumn('status');
                }
                if (Schema::hasColumn('grievances', 'description')) {
                    $table->dropColumn('description');
                }
                if (Schema::hasColumn('grievances', 'grievance')) {
                    $table->dropColumn('grievance');
                }
                if (Schema::hasColumn('grievances', 'date')) {
                    $table->dropColumn('date');
                }
                if (Schema::hasColumn('grievances', 'program')) {
                    $table->dropColumn('program');
                }
                if (Schema::hasColumn('grievances', 'name')) {
                    $table->dropColumn('name');
                }
                if (Schema::hasColumn('grievances', 'student_id')) {
                    $table->dropColumn('student_id');
                }
                if (Schema::hasColumn('grievances', 'case_id')) {
                    $table->dropColumn('case_id');
                }
            });
        }
    }
};
