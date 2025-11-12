<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employer;
use App\Models\User;

class EmployerSeeder extends Seeder
{
    public function run(): void
    {
        $employerUser = User::where('email', 'employer@example.com')->first();

        Employer::create([
            'user_id' => $employerUser->id,
            'company_name' => 'TechCorp Pvt Ltd',
            'industry_type' => 'Software Development',
            'address' => 'Chennai, Tamil Nadu',
            'website' => 'https://techcorp.example.com',
            'gst_number' => 'GST12345',
            'verified' => 1,
        ]);
    }
}
