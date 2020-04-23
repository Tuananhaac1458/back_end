<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentsNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contents__news', function (Blueprint $table) {
            $table->id();
            
            $table->string('title_content')->nullable();
            $table->string('thubnail_content')->nullable();
            $table->string('url_content')->nullable();
            $table->longText('text_content')->nullable();
            $table->string('type',15)->nullable();
            $table->tinyInteger('part')->nullable();


            $table->bigInteger('id_news')->unsigned();
            $table->foreign('id_news')
                  ->references('id')->on('news');
                  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contents__news');
    }
}
