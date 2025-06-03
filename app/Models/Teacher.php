<?php

namespace App\Models;

use App\Observers\TeacherObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[ObservedBy([TeacherObserver::class])]
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

    public static function booted()
    {
        static::deleting(function ($teacher) {
            if($teacher->internships()->count() > 0) {
                throw new \Exception('Cannot delete a teacher with internships');
            }
        });
    }

    public function internships()
    {
        return $this->hasMany(Internship::class);
    }
}
