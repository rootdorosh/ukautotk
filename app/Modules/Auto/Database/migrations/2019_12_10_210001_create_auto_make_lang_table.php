<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAutoMakeLangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auto_make_lang', function (Blueprint $table) {
            $table->increments('translation_id');
            $table->boolean('is_translated')->default(0);
            $table->integer('make_id')->unsigned();
            $table->string('locale', 5)->index();
            $table->string('title')->nullable();
            $table->unique(['make_id', 'locale']);
            $table->foreign('make_id')->references('id')->on('auto_make')->onDelete('cascade');        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auto_make_lang');
    }
}
