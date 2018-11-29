<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersSubInformation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_information', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('address')->nullable();
            $table->string('version')->nullable();
            $table->string('post')->nullable();
            $table->string('city')->nullable();
            $table->string('phone')->nullable();
            $table->string('presentation')->nullable();
            $table->integer('age')->nullable()->default(0);
            $table->boolean('trained_leader')->nullable();
            $table->string('special_preparation')->nullable();
            $table->string('website')->nullable();
            $table->string('pathWebsiteScreen')->nullable();
            $table->string('avatar_path')->nullable();
            $table->integer('visitors_count')->default(0);
            $table->integer('website_link_count')->default(0);
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
        Schema::drop('user_information');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
