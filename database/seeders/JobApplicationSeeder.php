<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobApplication;
use App\Models\Employee;
use App\Models\JobListing;

class JobApplicationSeeder extends Seeder
{
    public function run(): void
    {
        $employee = Employee::first();
        $job = JobListing::first();

        JobApplication::create([
            'job_id' => $job->id,
            'employee_id' => $employee->id,
            'cover_letter' => 'I am excited to apply for this position.',
            'status' => 'pending',
        ]);
    }
}
