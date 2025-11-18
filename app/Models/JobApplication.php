<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

    // ✔ MATCH REAL TABLE NAME
    protected $table = 'applications';

    protected $fillable = [
        'job_id',
        'employee_id',
        'cover_letter',
        'status',
    ];

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
