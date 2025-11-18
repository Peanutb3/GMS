<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('grievance_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grievance_id')->constrained()->cascadeOnDelete();
            $table->string('action'); // created, status_changed, resolved, deleted
            $table->json('snapshot')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('staff_id')->nullable()->constrained('staff')->nullOnDelete();
            $table->timestamps();
            $table->index(['grievance_id','action']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grievance_histories');
    }
};