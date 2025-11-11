<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'employer_id',
        'title',
        'description',
        'qualification_required',
        'experience_required',
        'skills_required',
        'location',
        'salary_min',
        'salary_max',
        'job_type',
        'status',
    ];

    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }

    // Later: job will have many applications
    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
