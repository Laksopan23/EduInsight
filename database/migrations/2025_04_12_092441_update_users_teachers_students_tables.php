<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTeachersStudentsTables extends Migration
{
    public function up()
    {
        // Update users table
        Schema::table('users', function (Blueprint $table) {
            $table->string('email')->unique()->change();
            $table->string('password')->nullable(false)->change();
        });

        // Update teachers table
        Schema::table('teachers', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id_fk')->nullable()->after('user_id');
            $table->foreign('user_id_fk')->references('id')->on('users')->onDelete('cascade');
        });

        // Update students table
        Schema::table('students', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id_fk')->nullable()->after('user_id');
            $table->foreign('user_id_fk')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['user_id_fk']);
            $table->dropColumn('user_id_fk');
        });

        Schema::table('teachers', function (Blueprint $table) {
            $table->dropForeign(['user_id_fk']);
            $table->dropColumn('user_id_fk');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['email']);
            $table->string('password')->nullable()->change();
        });
    }
}
