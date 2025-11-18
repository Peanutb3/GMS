<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	public function up(): void
	{
		if (!Schema::hasTable('safe_loan_requests')) {
			Schema::create('safe_loan_requests', function (Blueprint $table) {
				$table->id();
				$table->date('date_needed')->nullable();
				$table->string('email')->nullable();
				$table->string('contact')->nullable();
				$table->string('first_name');
				$table->string('middle_name')->nullable();
				$table->string('last_name');
				$table->enum('gender', ['Female','Male','Prefer not to say'])->nullable();
				$table->string('program_year')->nullable();
				$table->enum('student_status', ['currently_enrolled','not_enrolled'])->nullable();
				$table->string('last_semester')->nullable();
				$table->string('year_graduated')->nullable();
				$table->text('purpose')->nullable();
				$table->decimal('loan_amount',12,2)->default(0);
				$table->enum('status', ['pending','approved','rejected'])->default('pending');
				$table->timestamps();
			});
		}
	}

	public function down(): void
	{
		Schema::dropIfExists('safe_loan_requests');
	}
};
