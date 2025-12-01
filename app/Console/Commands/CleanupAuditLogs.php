<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AuditLog;

class CleanupAuditLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'audit:cleanup {--days=365}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up audit logs older than specified days (default: 365)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $days = $this->option('days');

        $this->info("Cleaning up audit logs older than {$days} days...");

        $cutoffDate = now()->subDays($days);

        $count = AuditLog::where('created_at', '<', $cutoffDate)->count();

        if ($count === 0) {
            $this->info('No audit logs to clean up.');
            return;
        }

        if ($this->confirm("This will delete {$count} audit log records. Continue?", true)) {
            $deleted = AuditLog::where('created_at', '<', $cutoffDate)->delete();
            $this->info("Successfully deleted {$deleted} audit log records.");
        } else {
            $this->info('Cleanup cancelled.');
        }
    }
}
