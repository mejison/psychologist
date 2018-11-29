<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegisterSupervisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('register_supervisions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('supervision_id')->unsigned();
            $table->string('role');
            $table->date('registration_date');
            $table->string('supervision_type');
            $table->string('number_of_hours');
            $table->string('udredning_intervention')->nullable();
            $table->string('type_work')->nullable();
            $table->string('type_classes');
            $table->string('group_composition')->nullable();
            $table->string('long_course')->nullable();
            $table->string('percentPsychology')->nullable();
            $table->text('comment')->nullable();
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
        Schema::dropIfExists('register_supervisions');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
