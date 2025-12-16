<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

$studentCount = DB::table('students')->count();
echo "Total Students: $studentCount\n\n";

if ($studentCount > 0) {
    $students = DB::table('students')
        ->join('users', 'students.user_id', '=', 'users.id')
        ->select('students.id', 'students.student_id', 'students.first_name', 'students.last_name', 'users.email')
        ->take(5)
        ->get();

    echo "Registered Students:\n";
    foreach ($students as $s) {
        echo "ID: {$s->id}, Student ID: {$s->student_id}, Name: {$s->first_name} {$s->last_name}, Email: {$s->email}\n";
    }
} else {
    echo "No students registered yet.\n";
    echo "\nThe students from the grievances (student_no_snapshot) need to register in the system first.\n";
    echo "They can register at: " . url('/register') . "\n";
}
