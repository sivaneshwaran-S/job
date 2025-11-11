<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'gender',
        'dob',
        'qualification',
        'experience_years',
        'skills',
        'resume_file',
        'preferred_location',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // For later: employee has many applications and reviews
    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
