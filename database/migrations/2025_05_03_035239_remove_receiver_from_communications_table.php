<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('communications', function (Blueprint $table) {
            $table->dropColumn('receiver');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('communications', function (Blueprint $table) {
            $table->string('receiver');
        });
    }
};
