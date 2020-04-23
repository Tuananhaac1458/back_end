<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('id_user')->unique();
            
            $table->string('id_social')->nullable();
            $table->string('phone_number',15)->unique();
            $table->string('password')->nullable();
            $table->string('email')->nullable();
            $table->string('user_name')->nullable();
            $table->string('url_avatar')->nullable();
            $table->date('birt_day')->nullable();
            $table->integer('point')->nullable();
            $table->boolean('phone_verified_at')->nullable();
            $table->string('token')->nullable();

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
