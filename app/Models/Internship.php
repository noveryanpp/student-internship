<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Internship extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'industry_id',
        'teacher_id',
        'start_date',
        'end_date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function industry()
    {
        return $this->belongsTo(Industry::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
