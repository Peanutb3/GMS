<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Staff extends Model
{
    use HasFactory;

    protected $table = 'staff';

    protected $fillable = [
        'user_id',
        'employee_id',
        'first_name',
        'middle_initial',
        'last_name',
        'suffix',
        'role',
        'staff_type',
        'email',
        'profile_photo_path',
    ];

    // Relationship to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessor for displaying photo URLs
    public function getProfilePhotoUrlAttribute()
    {
        return $this->profile_photo_path
            ? asset('storage/' . $this->profile_photo_path)
            : null; // null means we’ll render SVG instead
    }

    public function grievancesFiled()
    {
        return $this->hasMany(Grievance::class, 'filed_by_staff_id');
    }
}

