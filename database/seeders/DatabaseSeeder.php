<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            EmployerSeeder::class,
            EmployeeSeeder::class,
            JobSeeder::class,
            ApplicationSeeder::class,
        ]);
    }
}
