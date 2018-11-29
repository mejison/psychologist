<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RegisterCoursesAttaches extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('register_courses_attaches', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('registerId');
            $table->string('name', 255);
            $table->string('file', 255);
            $table->string('type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::drop('register_courses_attaches');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
