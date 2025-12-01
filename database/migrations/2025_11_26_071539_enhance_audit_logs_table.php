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
        Schema::table('audit_logs', function (Blueprint $table) {
            $table->string('user_agent')->nullable()->after('ip_address');
            $table->string('request_method')->nullable()->after('user_agent');
            $table->string('request_url')->nullable()->after('request_method');
            $table->text('description')->nullable()->after('request_url');
            $table->string('status')->default('success')->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('audit_logs', function (Blueprint $table) {
            $table->dropColumn(['user_agent', 'request_method', 'request_url', 'description', 'status']);
        });
    }
};
