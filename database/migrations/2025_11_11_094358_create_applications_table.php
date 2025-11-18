<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();

            // NEW FK to jobs table
            $table->foreignId('job_id')->constrained('jobs')->onDelete('cascade');

            // NEW FK to employees table
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');

            $table->text('cover_letter')->nullable();

            $table->enum('status', [
                'pending', 'reviewed', 'shortlisted', 'rejected', 'approved'
            ])->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
