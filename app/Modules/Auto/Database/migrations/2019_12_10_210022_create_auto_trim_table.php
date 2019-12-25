<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAutoTrimTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auto_trim', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('model_year_id')->unsigned();
            $table->integer('generation_id')->nullable()->unsigned();
            $table->integer('market_id')->nullable()->unsigned();
            $table->integer('engine_id')->nullable()->unsigned();
            $table->integer('thread_size_id')->nullable()->unsigned();
            $table->boolean('is_active')->default(1);
            $table->string('slug')->nullable();
            $table->string('vehicle_id')->nullable();
            $table->string('title');
            $table->text('options')->nullable();
            $table->integer('power_hp')->nullable();
            $table->integer('power_kw')->nullable();
            $table->integer('power_ps')->nullable();
            $table->integer('torque')->nullable();
            $table->decimal('center_bore', 4, 1)->nullable();
            $table->string('wheel_fasteners')->nullable();
            $table->string('trim_production')->nullable();
            $table->foreign('generation_id')->references('id')->on('auto_generation')->onDelete('cascade');                                
            $table->foreign('market_id')->references('id')->on('auto_market')->onDelete('cascade');                                
            $table->foreign('engine_id')->references('id')->on('auto_engine')->onDelete('cascade');                                
            $table->foreign('model_year_id')->references('id')->on('auto_model_year')->onDelete('cascade');                                
            $table->foreign('thread_size_id')->references('id')->on('auto_thread_size')->onDelete('cascade');                                
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auto_trim');
    }
}
