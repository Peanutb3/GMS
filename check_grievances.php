<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$grievances = DB::table('grievances')->latest()->take(5)->get(['id', 'case_id', 'student_record_id', 'name_snapshot', 'status', 'filed_by_staff_id', 'created_at']);

echo "Recent Grievances:\n";
foreach ($grievances as $g) {
    echo "ID: {$g->id}, Case: {$g->case_id}, Student Record ID: {$g->student_record_id}, Name: {$g->name_snapshot}, Status: {$g->status}, Filed by Staff: {$g->filed_by_staff_id}, Created: {$g->created_at}\n";
}
