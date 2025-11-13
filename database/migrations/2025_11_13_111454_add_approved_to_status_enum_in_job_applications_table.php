<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update ENUM field to include 'approved'
        DB::statement("ALTER TABLE job_applications 
            MODIFY COLUMN status ENUM('pending','reviewed','shortlisted','rejected','approved') 
            NOT NULL DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rollback to old ENUM (without 'approved')
        DB::statement("ALTER TABLE job_applications 
            MODIFY COLUMN status ENUM('pending','reviewed','shortlisted','rejected') 
            NOT NULL DEFAULT 'pending'");
    }
};
