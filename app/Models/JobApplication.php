<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id',
        'employee_id',
        'cover_letter',
    ];

    public function job()
    {
        return $this->belongsTo(JobListing::class, 'job_id');
    }
    public function applications()
{
    return $this->hasMany(\App\Models\JobApplication::class, 'job_id');
}

public function employer()
{
    return $this->belongsTo(\App\Models\Employer::class, 'employer_id');
}


    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
