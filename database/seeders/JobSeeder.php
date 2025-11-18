<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Job;
use App\Models\Employer;

class JobSeeder extends Seeder
{
    public function run(): void
    {
        $employer = Employer::first();

        Job::create([
            'employer_id' => $employer->id,
            'title' => 'Frontend Developer',
            'description' => 'Looking for a frontend developer proficient in React and Tailwind CSS.',
            'qualification_required' => 'B.Tech in Computer Science',
            'experience_required' => 1,
            'skills_required' => 'React, Tailwind, JavaScript',
            'location' => 'Chennai',
            'salary_min' => 40000,
            'salary_max' => 60000,
            'job_type' => 'full-time',
            'status' => 'open',
        ]);
    }
}
