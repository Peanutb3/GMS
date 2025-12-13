<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'college_id',
        'name',
        'code',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the college that owns the program.
     */
    public function college()
    {
        return $this->belongsTo(College::class);
    }

    /**
     * Scope a query to only include active programs.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
