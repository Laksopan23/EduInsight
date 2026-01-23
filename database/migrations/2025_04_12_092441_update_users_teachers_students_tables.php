<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTeachersStudentsTables extends Migration
{
    public function up()
    {
        // Update users table - make email unique if not already
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'email')) {
                $table->string('email')->unique();
            } else {
                // Only add unique constraint if it doesn't exist
                $table->unique('email');
            }
        });

        // Update teachers table
        Schema::table('teachers', function (Blueprint $table) {
            if (!Schema::hasColumn('teachers', 'user_id_fk')) {
                $table->unsignedBigInteger('user_id_fk')->nullable()->after('user_id');
                $table->foreign('user_id_fk')->references('id')->on('users')->onDelete('cascade');
            }
        });

        // Update students table
        Schema::table('students', function (Blueprint $table) {
            if (!Schema::hasColumn('students', 'user_id_fk')) {
                $table->unsignedBigInteger('user_id_fk')->nullable()->after('user_id');
                $table->foreign('user_id_fk')->references('id')->on('users')->onDelete('cascade');
            }
        });
    }

    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            if (Schema::hasColumn('students', 'user_id_fk')) {
                $table->dropForeign(['user_id_fk']);
                $table->dropColumn('user_id_fk');
            }
        });

        Schema::table('teachers', function (Blueprint $table) {
            if (Schema::hasColumn('teachers', 'user_id_fk')) {
                $table->dropForeign(['user_id_fk']);
                $table->dropColumn('user_id_fk');
            }
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['email']);
        });
    }
}
