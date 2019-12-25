<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAutoGenerationLangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auto_generation_lang', function (Blueprint $table) {
            $table->increments('translation_id');
            $table->boolean('is_translated')->default(0);
            $table->integer('generation_id')->unsigned();
            $table->string('locale', 5)->index();
            $table->string('title')->nullable();
            $table->unique(['generation_id', 'locale']);
            $table->foreign('generation_id')->references('id')->on('auto_generation')->onDelete('cascade');        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auto_generation_lang');
    }
}
