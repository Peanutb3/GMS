<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('good_moral_requests', function (Blueprint $table) {
            $table->string('college')->nullable()->after('gender');
            $table->string('program')->nullable()->after('college');
            $table->string('year')->nullable()->after('program');
            $table->string('from_sy')->nullable()->after('last_semester');
            $table->string('to_sy')->nullable()->after('from_sy');
        });
    }

    public function down(): void
    {
        Schema::table('good_moral_requests', function (Blueprint $table) {
            $table->dropColumn(['college', 'program', 'year', 'from_sy', 'to_sy']);
        });
    }
};
