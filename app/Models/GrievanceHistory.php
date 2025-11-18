<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrievanceHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'grievance_id','action','snapshot','notes','staff_id'
    ];

    protected $casts = [
        'snapshot'=>'array'
    ];

    public function grievance()
    {
        return $this->belongsTo(Grievance::class);
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}