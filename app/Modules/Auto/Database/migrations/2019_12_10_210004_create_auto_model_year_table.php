<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAutoModelYearTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auto_model_year', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('model_id')->unsigned();
            $table->mediumInteger('year')->unsigned();
            $table->boolean('is_active')->default(1);
            $table->integer('bolt_pattern_id')->nullable()->unsigned();
            $table->unique(['model_id', 'year']);
            $table->foreign('model_id')->references('id')->on('auto_model')->onDelete('cascade');                    
            $table->foreign('bolt_pattern_id')->references('id')->on('auto_bolt_pattern')->onDelete('SET NULL');                                
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auto_model_year');
    }
}
