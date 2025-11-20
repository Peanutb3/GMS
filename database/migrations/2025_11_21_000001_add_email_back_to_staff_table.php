<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up(): void
	{
		if (Schema::hasTable('staff') && ! Schema::hasColumn('staff', 'email')) {
			Schema::table('staff', function (Blueprint $table) {
				$table->string('email')->unique()->nullable()->after('phone');
			});
		}
	}

	public function down(): void
	{
		if (Schema::hasTable('staff') && Schema::hasColumn('staff', 'email')) {
			Schema::table('staff', function (Blueprint $table) {
				// drop unique first (name generated automatically, safe to attempt)
				try { $table->dropUnique(['email']); } catch (\Throwable $e) { /* ignore */ }
				$table->dropColumn('email');
			});
		}
	}
};

