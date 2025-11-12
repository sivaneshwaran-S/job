<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 👑 Admin (approved)
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'approved', // ✅ admin is immediately active
        ]);

        // 💼 Employer (pending)
        User::create([
            'name' => 'TechCorp Employer',
            'email' => 'employer@example.com',
            'password' => Hash::make('password'),
            'role' => 'employer',
            'status' => 'pending', // ⏳ waiting for admin approval
        ]);

        // 👨‍💼 Employee (pending)
        User::create([
            'name' => 'John Employee',
            'email' => 'employee@example.com',
            'password' => Hash::make('password'),
            'role' => 'employee',
            'status' => 'pending', // ⏳ waiting for admin approval
        ]);
    }
}
