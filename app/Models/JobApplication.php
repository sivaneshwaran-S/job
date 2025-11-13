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
        'status',
    ];

    // ✅ Correct relationship to JobListing model
    public function job()
    {
        return $this->belongsTo(JobListing::class, 'job_id');
    }

    // ✅ Relationship to Employee model
    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id'); // or Employee::class if separate
    }
}
