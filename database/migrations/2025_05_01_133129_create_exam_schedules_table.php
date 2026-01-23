<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamSchedulesTable extends Migration
{
    public function up()
    {
        Schema::create('exam_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('grade');
            $table->string('category');
            $table->string('subject');
            $table->date('exam_date');
            $table->time('exam_time');
            $table->string('venue')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('exam_schedules');
    }
}
