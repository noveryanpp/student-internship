<?php

namespace App\Models;

use App\Observers\StudentObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

//#[ObservedBy([StudentObserver::class])]
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

    public function internships()
    {
        return $this->hasMany(Internship::class);
    }

    public function internship_requests()
    {
        return $this->hasMany(InternshipRequest::class);
    }
}
