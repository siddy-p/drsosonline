<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('doctor_id')->nullable()->constrained('doctors')->onDelete('cascade');
            
            $table->string('patient_name', 150);
            $table->string('patient_email', 150);
            $table->string('patient_phone', 20);
            $table->string('patient_age', 10)->nullable();
            $table->string('patient_gender', 20)->nullable();
            
            $table->string('appointment_date', 20);
            $table->string('appointment_time', 10);
            $table->string('consult_type', 20);
            $table->text('reason')->nullable();
            $table->text('symptoms')->nullable();
            
            $table->integer('fee')->nullable();
            $table->string('payment_status', 20)->default('pending');
            $table->string('status', 20)->default('pending');
            $table->text('doctor_notes')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
