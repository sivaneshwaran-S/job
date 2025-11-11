<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id'); // Primary Key
            $table->string('name', 100); // Full name
            $table->string('email', 100)->unique(); // Unique email
            $table->string('password', 255); // Hashed password
            $table->enum('role', ['employee', 'employer', 'admin'])->default('employee'); // User type
            $table->string('phone', 15)->nullable(); // Contact number
            $table->string('location', 100)->nullable(); // City/District
            $table->tinyInteger('status')->default(1); // 1 = Active, 0 = Inactive

            // Laravel built-in fields
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps(); // created_at, updated_at
        });

        // Password Reset Tokens (for Breeze)
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // Sessions Table (for Breeze)
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};
