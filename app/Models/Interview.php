<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'interview_date',
        'mode',
        'location',
        'remarks',
        'status',
    ];

    /**
     * 🔹 Each interview belongs to one job application.
     */
    public function application()
    {
        return $this->belongsTo(JobApplication::class, 'application_id');
    }

    /**
     * 🔹 Access related employee directly.
     */
    public function employee()
    {
        return $this->hasOneThrough(
            Employee::class,
            JobApplication::class,
            'id',           // JobApplication.id
            'id',           // Employee.id
            'application_id', // Interview.application_id
            'employee_id'   // JobApplication.employee_id
        );
    }

    /**
     * 🔹 Access job easily through the application.
     */
    public function job()
    {
        return $this->hasOneThrough(
            JobListing::class,
            JobApplication::class,
            'id',           // JobApplication.id
            'id',           // JobListing.id
            'application_id', // Interview.application_id
            'job_id'        // JobApplication.job_id
        );
    }
}
