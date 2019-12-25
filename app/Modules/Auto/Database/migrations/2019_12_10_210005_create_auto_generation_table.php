<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAutoGenerationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auto_generation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('model_id')->unsigned();
            $table->string('d_slug')->nullable();
            $table->boolean('is_active')->default(1);
            $table->mediumInteger('year_from', false, true);
            $table->mediumInteger('year_to', false, true)->nullable();
            $table->foreign('model_id')->references('id')->on('auto_model')->onDelete('cascade');                    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auto_generation');
    }
}
