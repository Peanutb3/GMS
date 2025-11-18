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
    'student_record_id',
    'student_no_snapshot',
    'name_snapshot',
    'program_snapshot',
    'gender_snapshot',
    'date',
    'grievance',
    'description',
    'status',
    'filed_by_staff_id',
    'filed_by_name_snapshot',
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
                $grievance->filed_by_name_snapshot = trim(($user->staff->first_name ?? '') . ' ' . ($user->staff->last_name ?? ''));
            } elseif ($user && empty($grievance->filed_by_name_snapshot)) {
                $grievance->filed_by_name_snapshot = $user->name ?? null;
            }
        });
    }

    // Relationships
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_record_id');
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'filed_by_staff_id');
    }

    public function getFiledByDisplayAttribute(): string
    {
        if ($this->relationLoaded('staff') ? $this->staff : $this->staff()->exists()) {
            $s = $this->staff;
            return trim(($s->first_name ?? '') . ' ' . ($s->last_name ?? ''));
        }
        return (string) ($this->filed_by_name_snapshot ?? '');
    }
}
