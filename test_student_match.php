<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

echo "Testing Student Lookup:\n";
echo "======================\n\n";

// Get students
$students = \App\Models\Student::with('user')->get();

echo "Found {$students->count()} students:\n";
foreach ($students as $student) {
    echo "- Student ID (decrypted): {$student->student_id}\n";
    echo "  Name: {$student->first_name} {$student->last_name}\n";
    echo "  Email: " . ($student->user ? $student->user->email : 'No user') . "\n\n";
}

// Get recent grievances
echo "\nRecent Grievances:\n";
echo "==================\n\n";

$grievances = \App\Models\Grievance::latest()->take(3)->get();

foreach ($grievances as $g) {
    echo "Case ID: {$g->case_id}\n";
    echo "Student No Snapshot: " . ($g->student_no_snapshot ?? 'NULL') . "\n";
    echo "Student Record ID: " . ($g->student_record_id ?? 'NULL') . "\n";

    // Try to find matching student
    $matchingStudent = $students->first(function ($s) use ($g) {
        return $s->student_id === $g->student_no_snapshot;
    });

    if ($matchingStudent) {
        echo "✓ MATCH FOUND: {$matchingStudent->first_name} {$matchingStudent->last_name} ({$matchingStudent->user->email})\n";
    } else {
        echo "✗ No matching student found\n";
    }

    echo "\n";
}
