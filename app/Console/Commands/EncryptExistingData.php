<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Student;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class EncryptExistingData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'encrypt:data {model?} {--dry-run}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Encrypt existing sensitive data in the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $model = $this->argument('model');
        $dryRun = $this->option('dry-run');

        if ($dryRun) {
            $this->warn('DRY RUN MODE - No data will be modified');
        }

        if (!$model || $model === 'Student') {
            $this->encryptStudentData($dryRun);
        }

        $this->info('Encryption process completed!');
    }

    private function encryptStudentData($dryRun = false)
    {
        $this->info('Encrypting Student data...');

        $students = Student::all();
        $bar = $this->output->createProgressBar(count($students));

        $encrypted = 0;
        $skipped = 0;

        foreach ($students as $student) {
            $needsUpdate = false;

            // Check if student_id needs encryption
            if ($student->student_id) {
                try {
                    // Try to decrypt - if it works, already encrypted
                    Crypt::decryptString($student->student_id);
                    $skipped++;
                } catch (\Exception $e) {
                    // Not encrypted, needs encryption
                    if (!$dryRun) {
                        DB::table('students')
                            ->where('id', $student->id)
                            ->update([
                                'student_id' => Crypt::encryptString($student->student_id),
                            ]);
                    }
                    $needsUpdate = true;
                    $encrypted++;
                }
            }

            // Check if phone needs encryption (if not null)
            if ($student->phone) {
                try {
                    Crypt::decryptString($student->phone);
                } catch (\Exception $e) {
                    if (!$dryRun && !$needsUpdate) {
                        DB::table('students')
                            ->where('id', $student->id)
                            ->update([
                                'phone' => Crypt::encryptString($student->phone),
                            ]);
                    }
                    $needsUpdate = true;
                }
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        $this->info("Students processed: " . count($students));
        $this->info("Records encrypted: {$encrypted}");
        $this->info("Already encrypted (skipped): {$skipped}");

        if ($dryRun) {
            $this->warn('This was a dry run. Run without --dry-run to actually encrypt data.');
        }
    }
}
