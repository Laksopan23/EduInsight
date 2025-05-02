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
            $table->string('meeting_link')->nullable()->after('receiver');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('communications', function (Blueprint $table) {
            $table->dropColumn('meeting_link');
        });
    }
};
