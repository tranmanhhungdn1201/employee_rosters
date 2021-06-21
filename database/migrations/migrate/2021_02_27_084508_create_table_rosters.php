<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRosters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rosters', function (Blueprint $table) {
            $table->increments('id');
            $table->date('day_start');
            $table->date('day_finish');
            $table->dateTime('time_open');
            $table->dateTime('time_close');
            $table->tinyInteger('status');
            $table->integer('user_created_id');
            $table->integer('user_updated_id');
            $table->integer('branch_id');
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
        Schema::table('rosters', function (Blueprint $table) {
            Schema::dropIfExists('rosters');
        });
    }
}
