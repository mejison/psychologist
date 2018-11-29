<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_modules', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('Arbejds_og_organisationspsykologi')->nullable()->default(0);
            $table->boolean('Børnemodulet')->nullable()->default(0);
            $table->boolean('Voksenmodulet')->nullable()->default(0);
            $table->boolean('Det_tværgående')->nullable()->default(0);
            $table->boolean('Forsknings_og_formidlingsmodulet')->nullable()->default(0);
            $table->boolean('Specialiseringsmodulerne')->nullable()->default(0);
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
        Schema::drop('course_modules');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
