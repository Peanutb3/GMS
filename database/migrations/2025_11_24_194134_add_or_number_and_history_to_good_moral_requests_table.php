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
        Schema::table('good_moral_requests', function (Blueprint $table) {
            $table->string('or_number')->nullable()->after('status');
            $table->timestamp('or_entered_at')->nullable()->after('or_number');
            $table->timestamp('completed_at')->nullable()->after('or_entered_at');
            $table->string('reference_no')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('good_moral_requests', function (Blueprint $table) {
            $table->dropColumn(['or_number', 'or_entered_at', 'completed_at', 'reference_no']);
        });
    }
};
