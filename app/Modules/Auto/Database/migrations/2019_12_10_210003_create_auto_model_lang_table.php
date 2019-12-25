<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAutoModelLangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auto_model_lang', function (Blueprint $table) {
            $table->increments('translation_id');
            $table->boolean('is_translated')->default(0);
            $table->integer('model_id')->unsigned();
            $table->string('locale', 5)->index();
            $table->string('title')->nullable();
            $table->unique(['model_id', 'locale']);
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
        Schema::dropIfExists('auto_model_lang');
    }
}
