<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('id_news')->nullable();
            $table->string('title_news')->nullable();
            $table->longText('subtitle_news')->nullable();
            $table->string('thubnail_news')->nullable();
            $table->string('type',15)->nullable();
            // $table->mediumInteger('like');
            $table->boolean('isComment')->nullable();
            $table->boolean('isShare')->nullable();
            $table->bigInteger('id_auth')->unsigned();
            $table->foreign('id_auth')
                  ->references('id')->on('users');

            $table->boolean('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news');
    }
}
