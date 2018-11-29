<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegisterCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('register_courses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('userId');
            $table->integer('courseId');
            $table->string('name');
            $table->string('date');
            $table->string('code');
            $table->string('timer');
            $table->text('comment');
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
       Schema::drop('register_courses');
       DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
