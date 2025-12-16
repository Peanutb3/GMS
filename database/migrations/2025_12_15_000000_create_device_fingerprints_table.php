<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('device_fingerprints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('fingerprint_hash', 64)->index();
            $table->string('device_name')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamp('last_seen_at');
            $table->timestamps();

            $table->index(['user_id', 'fingerprint_hash']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('device_fingerprints');
    }
};
