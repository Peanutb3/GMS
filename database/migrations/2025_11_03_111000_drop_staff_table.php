<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // If grievances references staff, remove FK/column first
        if (Schema::hasTable('grievances')) {
            try {
                Schema::table('grievances', function (Blueprint $table) {
                    if (Schema::hasColumn('grievances', 'filed_by_staff_id')) {
                        // drop foreign key if named conventionally
                        try {
                            $table->dropForeign(['filed_by_staff_id']);
                        } catch (\Exception $__e) {
                            // ignore
                        }

                        $table->dropColumn('filed_by_staff_id');
                    }
                });
            } catch (\Exception $__e) {
                // ignore any errors adjusting grievances
            }
        }

        Schema::dropIfExists('staff');
    }

    public function down(): void
    {
        // Recreate a minimal staff table so rollback doesn't error.
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id')->unique()->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('position')->nullable();
            $table->string('office')->nullable();
            $table->string('role')->default('staff');
            $table->string('profile_photo')->nullable();
            $table->timestamps();
        });
    }
};
