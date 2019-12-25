<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAutoTrimWheel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auto_trim_wheel', function (Blueprint $table) {
            $table->integer('trim_id')->unsigned();
            $table->integer('front_id')->unsigned();
            $table->integer('rear_id')->unsigned()->nullable();
            $table->boolean('is_stock')->default(0);
            $table->decimal('front_pressure', 2,1)->unsigned();
            $table->decimal('rear_pressure', 2,1)->unsigned()->nullable();
            
            $table->foreign('trim_id')->references('id')->on('auto_trim')->onDelete('cascade');                                
            $table->foreign('front_id')->references('id')->on('auto_wheel')->onDelete('cascade');                                
            $table->foreign('rear_id')->references('id')->on('auto_wheel')->onDelete('cascade');                                
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auto_trim_wheel');
    }
}
