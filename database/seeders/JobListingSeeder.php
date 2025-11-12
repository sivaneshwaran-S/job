<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobListing;
use App\Models\Employer;

class JobListingSeeder extends Seeder
{
    public function run(): void
    {
        $employer = Employer::first();

        JobListing::create([
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
