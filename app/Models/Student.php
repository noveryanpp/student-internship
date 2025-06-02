<?php

namespace App\Models;

use App\Observers\StudentObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([StudentObserver::class])]
class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'nis',
        'gender',
        'address',
        'phone',
        'email',
        'image',
        'internship_status',
    ];

    public static function booted()
    {
        static::deleting(function ($student) {
            if($student->internships()->count() > 0) {
                throw new \Exception('Cannot delete a student with internships');
            }
            if($student->internship_requests()->count() > 0) {
                throw new \Exception('Cannot delete a student with internship requests');
            }
        });
    }

    public function internships()
    {
        return $this->hasMany(Internship::class);
    }

    public function internship_requests()
    {
        return $this->hasMany(InternshipRequest::class);
    }
}
