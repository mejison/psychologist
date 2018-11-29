<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePsychologistSupervisions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('psychologist_supervision', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('name');
            $table->string('surname');
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('post')->nullable();
            $table->string('city')->nullable();
            $table->string('phone')->nullable();
            $table->string('special_preparation');
            $table->string('special_evidence')->nullable();
            $table->boolean('special_trained')->nullable();
            $table->boolean('supervisor_selected')->default(0);
            $table->text('presentation_description')->nullable();
            $table->string('form_type')->nullable();

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
        Schema::drop('psychologist_supervision');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
