<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address__users', function (Blueprint $table) {
            $table->id();
            
            $table->string('title')->nullable();
            $table->string('type')->nullable();
            $table->char('longitude',15)->nullable();
            $table->char('latitude',15)->nullable();
            $table->boolean('default')->nullable();


            $table->bigInteger('id_user')->unsigned();
            $table->foreign('id_user')
                  ->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('address__users');
    }
}
