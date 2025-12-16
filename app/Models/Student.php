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

    /**
     * Get the program abbreviation from the full program name.
     * Extracts abbreviation from format like "Bachelor of Science in Information Technology" -> "BSIT"
     */
    public function getProgramAbbrAttribute()
    {
        if (empty($this->program)) {
            return '—';
        }

        // If program is numeric, it's an ID - look it up
        if (is_numeric($this->program)) {
            $program = Program::find($this->program);
            return $program && !empty($program->code) ? $program->code : '—';
        }

        // Check if program name looks like it already contains parentheses with abbreviation
        if (preg_match('/\(([A-Z]+)\)/', $this->program, $matches)) {
            return $matches[1];
        }

        // Try to find program in programs table and get its code
        $program = Program::where('name', $this->program)->first();
        if ($program && !empty($program->code)) {
            return $program->code;
        }

        // Fallback: extract capital letters from program name
        // e.g., "Bachelor of Science in Information Technology" -> "BSIT"
        $words = explode(' ', $this->program);
        $abbr = '';
        foreach ($words as $word) {
            if (!empty($word) && ctype_upper($word[0]) && !in_array(strtolower($word), ['of', 'in', 'and', 'the'])) {
                $abbr .= $word[0];
            }
        }

        return !empty($abbr) ? $abbr : $this->program;
    }

    /**
     * Get the college name (handles both ID and name stored in column).
     */
    public function getCollegeNameAttribute()
    {
        if (empty($this->college)) {
            return '—';
        }

        // If college is numeric, it's an ID - look it up
        if (is_numeric($this->college)) {
            $college = College::find($this->college);
            return $college ? $college->name : '—';
        }

        // Otherwise it's already the name
        return $this->college;
    }

    /**
     * Get the program name (handles both ID and name stored in column).
     */
    public function getProgramNameAttribute()
    {
        if (empty($this->program)) {
            return '—';
        }

        // If program is numeric, it's an ID - look it up
        if (is_numeric($this->program)) {
            $program = Program::find($this->program);
            return $program ? $program->name : '—';
        }

        // Otherwise it's already the name
        return $this->program;
    }

    /**
     * Get the college abbreviation.
     * Automatically generates abbreviation from college name.
     */
    public function getCollegeAbbrAttribute()
    {
        if (empty($this->college)) {
            return '—';
        }

        // If college is numeric, it's an ID - look it up
        if (is_numeric($this->college)) {
            $college = College::find($this->college);
            return $college && !empty($college->code) ? $college->code : '—';
        }

        // Otherwise, work with the college name
        $collegeName = $this->college;

        // Try to find college in colleges table and get its code/abbreviation
        $college = College::where('name', $collegeName)->first();
        if ($college && !empty($college->code)) {
            return $college->code;
        }

        // Fallback: Auto-generate abbreviation by extracting capital letters
        // Example: "College of Information and Computing" -> "CIC"
        $words = explode(' ', $collegeName);
        $abbr = '';

        foreach ($words as $word) {
            if (!empty($word) && ctype_upper($word[0])) {
                // Skip common words
                if (!in_array(strtolower($word), ['of', 'and', 'the', 'for'])) {
                    $abbr .= strtoupper($word[0]);
                }
            }
        }

        return !empty($abbr) ? $abbr : $collegeName;
    }
}
