<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesNumbersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_numbers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('groups_id')->unsigned();
            $table->string('number')->nullabel();
            $table->string('name')->nullabel();
            $table->integer('time')->unsigned();
            $table->text('comment')->nullabel();
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
        Schema::drop('course_numbers');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
