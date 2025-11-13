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
    return $this->belongsTo(User::class, 'user_id');
}

public function applications()
{
    return $this->hasMany(JobApplication::class, 'employee_id');
}



    // public function reviews()
    // {
    //     return $this->hasMany(Review::class);
    // }
}
