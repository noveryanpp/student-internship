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

    public function internships()
    {
        return $this->hasMany(Internship::class);
    }

    public function internship_requests()
    {
        return $this->hasMany(InternshipRequest::class);
    }
}
