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
        Schema::create('employers', function (Blueprint $table) {
            $table->bigIncrements('id'); // Primary Key
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // FK → users.id
            $table->string('company_name', 150); // Company name
            $table->string('industry_type', 100)->nullable(); // Industry sector
            $table->text('address')->nullable(); // Company address
            $table->string('website', 150)->nullable(); // Website link
            $table->string('gst_number', 50)->nullable(); // GST number
            $table->tinyInteger('verified')->default(0); // 0 = Not Verified, 1 = Verified
            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employers');
    }
};
