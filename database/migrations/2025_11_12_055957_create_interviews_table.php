<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('interviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('job_applications')->onDelete('cascade');

            // 🔹 Who requested and who attends
            $table->foreignId('employer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('employee_id')->constrained('users')->onDelete('cascade');

            // 🔹 Interview details
            $table->dateTime('interview_date')->nullable();
            $table->enum('mode', ['online', 'offline'])->nullable();
            $table->string('location', 150)->nullable(); // meeting address or link
            $table->text('remarks')->nullable(); // admin/employer notes

            // 🔹 Workflow tracking
            $table->enum('status', ['requested', 'scheduled', 'completed', 'cancelled'])->default('requested');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('interviews');
    }
};
