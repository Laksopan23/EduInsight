<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectsTable extends Migration
{
    public function up()
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('grade'); // Grade 6, Grade 7, ..., Grade 11
            $table->string('category'); // Core, Basket 1, Basket 2, Basket 3
            $table->boolean('is_mandatory')->default(false);
            $table->unique(['name', 'grade']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('subjects');
    }
}
