<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // good_moral_requests
        if (Schema::hasTable('good_moral_requests')) {
            Schema::table('good_moral_requests', function (Blueprint $table) {
                if (!Schema::hasColumn('good_moral_requests', 'reference_no')) {
                    $table->string('reference_no')->unique()->nullable()->after('id');
                }
                if (!Schema::hasColumn('good_moral_requests', 'staff_id')) {
                    if (Schema::hasTable('staff')) {
                        $table->foreignId('staff_id')->nullable()->constrained('staff')->nullOnDelete()->after('status');
                    } else {
                        // Fallback if staff table doesn't exist at migration time
                        $table->unsignedBigInteger('staff_id')->nullable()->after('status');
                        $table->index('staff_id');
                    }
                }
            });
        }

        // safe_loan_requests
        if (Schema::hasTable('safe_loan_requests')) {
            Schema::table('safe_loan_requests', function (Blueprint $table) {
                if (!Schema::hasColumn('safe_loan_requests', 'reference_no')) {
                    $table->string('reference_no')->unique()->nullable()->after('id');
                }
                if (!Schema::hasColumn('safe_loan_requests', 'staff_id')) {
                    if (Schema::hasTable('staff')) {
                        $table->foreignId('staff_id')->nullable()->constrained('staff')->nullOnDelete()->after('status');
                    } else {
                        $table->unsignedBigInteger('staff_id')->nullable()->after('status');
                        $table->index('staff_id');
                    }
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('good_moral_requests')) {
            Schema::table('good_moral_requests', function (Blueprint $table) {
                if (Schema::hasColumn('good_moral_requests', 'staff_id')) {
                    try { $table->dropConstrainedForeignId('staff_id'); } catch (\Throwable $e) { /* ignore */ }
                    try { $table->dropIndex(['staff_id']); } catch (\Throwable $e) { /* ignore */ }
                    $table->dropColumn('staff_id');
                }
                if (Schema::hasColumn('good_moral_requests', 'reference_no')) {
                    $table->dropUnique('good_moral_requests_reference_no_unique');
                    $table->dropColumn('reference_no');
                }
            });
        }

        if (Schema::hasTable('safe_loan_requests')) {
            Schema::table('safe_loan_requests', function (Blueprint $table) {
                if (Schema::hasColumn('safe_loan_requests', 'staff_id')) {
                    try { $table->dropConstrainedForeignId('staff_id'); } catch (\Throwable $e) { /* ignore */ }
                    try { $table->dropIndex(['staff_id']); } catch (\Throwable $e) { /* ignore */ }
                    $table->dropColumn('staff_id');
                }
                if (Schema::hasColumn('safe_loan_requests', 'reference_no')) {
                    $table->dropUnique('safe_loan_requests_reference_no_unique');
                    $table->dropColumn('reference_no');
                }
            });
        }
    }
};
