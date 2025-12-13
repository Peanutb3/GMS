<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class College extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the programs for the college.
     */
    public function programs()
    {
        return $this->hasMany(Program::class);
    }

    /**
     * Scope a query to only include active colleges.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
