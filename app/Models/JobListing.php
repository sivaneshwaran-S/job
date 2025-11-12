<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobListing extends Model
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
        'is_approved',
    ];

    public function employer()
    {
        return $this->belongsTo(Employer::class, 'employer_id');
    }

    public function applications()
    {
        return $this->hasMany(JobApplication::class, 'job_id');
    }
    public function interviews()
    {
        return $this->hasManyThrough(
            Interview::class,
            JobApplication::class,
            'job_id',          // Foreign key on job_applications
            'application_id',  // Foreign key on interviews
            'id',              // Local key on job_listings
            'id'               // Local key on job_applications
        );
    }
}
