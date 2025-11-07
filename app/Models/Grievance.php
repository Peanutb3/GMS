<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Grievance extends Model
{
    use HasFactory;

    protected $fillable = [
        'case_id',
        'student_id',
        'name',
        'program',
        'date',
        'grievance',
        'description',
        'status',
        'filed_by',
        'filed_by_staff_id',
    ];

    /**
     * Automatically fill staff info when created.
     */
    protected static function booted()
    {
        static::creating(function ($grievance) {
            $user = Auth::user();

            if ($user && $user->role === 'staff' && $user->staff) {
                $grievance->filed_by_staff_id = $user->staff->id;
                $grievance->filed_by = $user->staff->first_name . ' ' . $user->staff->last_name;
            }
        });
    }

    // Relationships
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'filed_by_staff_id');
    }
}
