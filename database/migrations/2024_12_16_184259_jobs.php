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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('company');
            $table->string('requirements', 350);
            $table->string('job_type', 255);
            $table->string('experience_level', 255)->nullable();
            $table->decimal('min_salary', 10, 2)->default(0);
            $table->decimal('max_salary', 10, 2)->default(0);
            $table->string('location', 255);
            $table->string('salary_type', 255);
            $table->date('application_deadline')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
