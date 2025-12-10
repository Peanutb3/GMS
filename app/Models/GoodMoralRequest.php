<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodMoralRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'reference_no',
        'staff_id',
        'date_needed',
        'email',
        'contact',
        'first_name',
        'middle_name',
        'last_name',
        'gender',
        'college',
        'program',
        'year',
        'student_status',
        'last_semester',
        'from_sy',
        'to_sy',
        'year_graduated',
        'purpose',
        'copies',
        'status',
        'or_number',
        'or_entered_at',
        'completed_at',
    ];

    protected $casts = [
        'or_entered_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function snapshot(): array
    {
        return $this->only([
            'student_id',
            'reference_no',
            'staff_id',
            'date_needed',
            'email',
            'contact',
            'first_name',
            'middle_name',
            'last_name',
            'gender',
            'college',
            'program',
            'year',
            'student_status',
            'last_semester',
            'from_sy',
            'to_sy',
            'year_graduated',
            'purpose',
            'copies',
            'status'
        ]);
    }
}
