<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->unique()->constrained('users')->onDelete('set null');
            $table->string('name', 100);
            $table->string('specialty', 100)->nullable();
            $table->string('qualification', 200)->nullable();
            $table->text('bio')->nullable();
            $table->string('languages', 200)->nullable();
            $table->string('photo_url', 300)->nullable();
            $table->integer('years_experience')->default(0);
            $table->string('available_days', 100)->default('Mon,Tue,Wed,Thu,Fri');
            $table->string('available_from', 8)->default('09:00');
            $table->string('available_to', 8)->default('18:00');
            $table->integer('fee_phone')->default(99);
            $table->integer('fee_video')->default(199);
            $table->double('rating')->default(4.8);
            $table->integer('total_consultations')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
