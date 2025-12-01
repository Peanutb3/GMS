<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\EncryptsAttributes;
use App\Traits\LogsActivity;

class Student extends Model
{
    use HasFactory, EncryptsAttributes, LogsActivity;

    /**
     * Attributes that should be encrypted.
     */
    protected $encrypted = [
        'student_id',
        'phone',
    ];

    protected $fillable = [
        'user_id',
        'student_id',
        'first_name',
        'middle_initial',
        'last_name',
        'suffix',
        'college',
        'program',
        'year',
        'profile_photo_path',
        'phone',
    ];


    // define relationship properly
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getProfilePhotoUrlAttribute()
    {
        return $this->profile_photo_path
            ? asset('storage/' . $this->profile_photo_path)
            : null; // null means we’ll render SVG instead
    }

    public function grievances()
    {
        return $this->hasMany(Grievance::class, 'student_record_id');
    }
}
