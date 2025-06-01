<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Industry extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'field',
        'address',
        'phone',
        'email',
        'website',
    ];

    public static function booted()
    {
        static::deleting(function ($industry) {
            if($industry->internships()->count() > 0) {
                throw new \Exception('Cannot delete an industry with internships');
            }
            if($industry->internship_requests()->count() > 0) {
                throw new \Exception('Cannot delete an industry with internship requests');
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
