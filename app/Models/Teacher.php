<?php

namespace App\Models;

use App\Observers\TeacherObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

//#[ObservedBy([TeacherObserver::class])]
class Teacher extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'nip',
        'gender',
        'address',
        'phone',
        'email',
    ];

    public function internships()
    {
        return $this->hasMany(Internship::class);
    }
}
