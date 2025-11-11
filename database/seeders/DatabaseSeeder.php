<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 🔹 Create default Admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'), // You can change this later
            'role' => 'admin',
            'phone' => '9999999999',
            'location' => 'Head Office',
            'status' => 1,
        ]);

        // 🔹 Optionally, create a demo Employer and Job Seeker
        User::create([
            'name' => 'Demo Employer',
            'email' => 'employer@example.com',
            'password' => Hash::make('employer123'),
            'role' => 'employer',
            'phone' => '8888888888',
            'location' => 'Chennai',
            'status' => 1,
        ]);

        User::create([
            'name' => 'Demo Job Seeker',
            'email' => 'seeker@example.com',
            'password' => Hash::make('seeker123'),
            'role' => 'employee',
            'phone' => '7777777777',
            'location' => 'Madurai',
            'status' => 1,
        ]);
    }
}
