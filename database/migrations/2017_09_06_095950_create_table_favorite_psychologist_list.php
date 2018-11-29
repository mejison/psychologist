<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableFavoritePsychologistList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('favorite_psychologist_list', function (Blueprint $table) {
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
         Schema::drop('favorite_psychologist_list');
         DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
