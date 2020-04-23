<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('address')->nullable();
            $table->string('style')->nullable();
            $table->char('longitude',15)->nullable();
            $table->char('latitude',15)->nullable();
            $table->string('numberPhone')->nullable();
            $table->integer('timeOpen')->nullable();
            $table->integer('timeClose')->nullable();
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
        Schema::dropIfExists('stores');
    }
}
