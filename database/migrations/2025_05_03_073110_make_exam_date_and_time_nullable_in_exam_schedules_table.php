<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeExamDateAndTimeNullableInExamSchedulesTable extends Migration
{
    public function up()
    {
        Schema::table('exam_schedules', function (Blueprint $table) {
            $table->date('exam_date')->nullable()->change();
            $table->time('exam_time')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('exam_schedules', function (Blueprint $table) {
            $table->date('exam_date')->nullable(false)->change();
            $table->time('exam_time')->nullable(false)->change();
        });
    }
};
