<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAutoMarketLangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auto_market_lang', function (Blueprint $table) {
            $table->increments('translation_id');
            $table->boolean('is_translated')->default(0);
            $table->integer('market_id')->unsigned();
            $table->string('locale', 5)->index();
            $table->string('title')->nullable();
            $table->unique(['market_id', 'locale']);
            $table->foreign('market_id')->references('id')->on('auto_market')->onDelete('cascade');        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auto_market_lang');
    }
}
