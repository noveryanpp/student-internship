<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternshipRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'industry_id',
        'start_date',
        'end_date',
        'status',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function industry()
    {
        return $this->belongsTo(Industry::class);
    }
}
