<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserShifts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_shifts', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('shift_id');
            $table->tinyInteger('user_id');
            $table->tinyInteger('status');
            $table->integer('work_time');
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
        Schema::table('user_shifts', function (Blueprint $table) {
            Schema::dropIfExists('user_shifts');
        });
    }
}
