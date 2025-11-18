<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	public function up(): void
	{
		Schema::table('safe_loan_requests', function (Blueprint $table) {
			if (!Schema::hasColumn('safe_loan_requests','student_id')) {
				$table->unsignedBigInteger('student_id')->nullable()->after('id');
			}
			if (!Schema::hasColumn('safe_loan_requests','reference_no')) {
				$table->string('reference_no')->nullable()->after('student_id');
			}
			if (!Schema::hasColumn('safe_loan_requests','staff_id')) {
				$table->unsignedBigInteger('staff_id')->nullable()->after('reference_no');
			}
		});
	}

	public function down(): void
	{
		Schema::table('safe_loan_requests', function (Blueprint $table) {
			if (Schema::hasColumn('safe_loan_requests','staff_id')) {
				$table->dropColumn('staff_id');
			}
			if (Schema::hasColumn('safe_loan_requests','reference_no')) {
				$table->dropColumn('reference_no');
			}
			if (Schema::hasColumn('safe_loan_requests','student_id')) {
				$table->dropColumn('student_id');
			}
		});
	}
};
