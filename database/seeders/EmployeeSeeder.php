<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\User;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $employeeUser = User::where('email', 'employee@example.com')->first();

        Employee::create([
            'user_id' => $employeeUser->id,
            'gender' => 'male',
            'dob' => '1999-05-20',
            'qualification' => 'B.Tech Computer Science',
            'experience_years' => 2,
            'skills' => 'HTML, CSS, JavaScript, Laravel',
            'preferred_location' => 'Chennai',
        ]);
    }
}
