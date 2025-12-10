<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('good_moral_requests', function (Blueprint $table) {
            if (Schema::hasColumn('good_moral_requests', 'program_year')) {
                $table->dropColumn('program_year');
            }
        });
    }

    public function down(): void
    {
        Schema::table('good_moral_requests', function (Blueprint $table) {
            $table->string('program_year')->nullable();
        });
    }
};
