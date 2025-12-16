<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

// Check mail configuration
echo "Mail Mailer: " . config('mail.default') . "\n";
echo "Mail From: " . config('mail.from.address') . "\n";
echo "Mail From Name: " . config('mail.from.name') . "\n\n";

// Check if we have any grievances
$grievances = DB::table('grievances')->latest()->take(3)->get(['id', 'case_id', 'student_record_id', 'student_no_snapshot', 'name_snapshot']);

echo "Recent Grievances:\n";
foreach ($grievances as $g) {
    echo "ID: {$g->id}, Case: {$g->case_id}, Student Record ID: " . ($g->student_record_id ?? 'NULL') . ", Student No: " . ($g->student_no_snapshot ?? 'NULL') . ", Name: {$g->name_snapshot}\n";

    // Check if student exists
    if ($g->student_no_snapshot) {
        $student = DB::table('students')->where('student_id', $g->student_no_snapshot)->first(['id', 'student_id', 'user_id']);
        if ($student) {
            $user = DB::table('users')->where('id', $student->user_id)->first(['email']);
            echo "  → Student found! ID: {$student->id}, User Email: " . ($user->email ?? 'No email') . "\n";
        } else {
            echo "  → Student NOT found in database\n";
        }
    }
}
