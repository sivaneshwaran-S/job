<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Job;


class Employer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_name',
        'industry_type',
        'address',
        'website',
        'gst_number',
        'verified',
    ];

    /**
     * Relationship: An employer belongs to one user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship: An employer can post many jobs.
     */
    public function jobs()
{
    return $this->hasMany(Job::class);
}

}
