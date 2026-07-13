<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
            $table->string('first_name', 100)->nullable();
            $table->string('last_name', 100)->nullable();
            $table->string('date_of_birth', 20)->nullable();
            $table->string('gender', 20)->nullable();
            $table->string('nationality', 100)->nullable();
            $table->string('phone', 30)->nullable();

            $table->string('street_address', 200)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('county_state', 100)->nullable();
            $table->string('country', 100)->nullable();
            $table->string('postcode', 20)->nullable();

            $table->string('passport_number', 50)->nullable();
            $table->string('passport_expiry', 20)->nullable();
            $table->string('passport_country', 100)->nullable();

            $table->string('highest_qualification', 100)->nullable();
            $table->string('institution_name', 200)->nullable();
            $table->string('graduation_year', 10)->nullable();
            $table->string('grade_achieved', 50)->nullable();
            $table->string('field_of_study', 150)->nullable();
            $table->string('english_test', 20)->nullable();
            $table->string('english_score', 20)->nullable();

            $table->string('preferred_country', 100)->nullable();
            $table->string('preferred_course', 200)->nullable();
            $table->string('intake_year', 10)->nullable();
            $table->string('intake_month', 20)->nullable();
            $table->string('budget_range', 50)->nullable();
            $table->text('additional_notes')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
