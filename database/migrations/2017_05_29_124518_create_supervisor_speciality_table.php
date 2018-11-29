<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupervisorSpecialityTable extends Migration
{
    public function up()
    {
        Schema::create('supervision_speciality', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('Eksistentiel_humanistisk')->nullable()->default(0);
            $table->boolean('Kognitiv_adfærdsterapeutisk')->nullable()->default(0);
            $table->boolean('Psykodynamisk_psykoanalytisk')->nullable()->default(0);
            $table->boolean('Systemisk_strukturel')->nullable()->default(0);
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
        Schema::drop('supervision_speciality');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
