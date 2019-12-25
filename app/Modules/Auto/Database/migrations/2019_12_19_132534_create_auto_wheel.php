<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAutoWheel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auto_wheel', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tire_width')->unsigned()->nullable();
            $table->integer('aspect_ratio')->unsigned()->nullable();
            $table->string('construction')->nullable();
            $table->integer('rim_diameter')->unsigned()->nullable();
            $table->integer('load_index')->unsigned()->nullable();
            $table->string('speed_rating')->nullable();
            $table->string('rim_width')->nullable();
            $table->integer('offset')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auto_wheel');
    }
}
