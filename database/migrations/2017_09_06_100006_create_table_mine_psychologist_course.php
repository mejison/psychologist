<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMinePsychologistCourse extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('mine_psychologist_course', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('userId');
            $table->integer('courseId');
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
        Schema::drop('mine_psychologist_course');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
