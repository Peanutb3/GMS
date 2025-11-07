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
        Schema::table('grievances', function (Blueprint $table) {
            // add the filed_by_staff_id column
            $table->unsignedBigInteger('filed_by_staff_id')->nullable()->after('filed_by');

            // add the foreign key relationship
            $table->foreign('filed_by_staff_id')
                  ->references('id')
                  ->on('staff')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('grievances', function (Blueprint $table) {
            $table->dropForeign(['filed_by_staff_id']);
            $table->dropColumn('filed_by_staff_id');
        });
    }
};
