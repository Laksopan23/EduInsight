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
        Schema::create('exam_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('grade'); // e.g., Grade 1, Grade 5, Grade 11
            $table->string('category'); // e.g., Term Test, Scholarship Exam, GCE O-Level, GCE A-Level
            $table->string('subject'); // e.g., Mathematics, Science
            $table->date('exam_date'); // Exam date
            $table->time('exam_time'); // Exam time
            $table->string('venue')->nullable(); // Venue (optional)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exam_schedules');
    }
};
