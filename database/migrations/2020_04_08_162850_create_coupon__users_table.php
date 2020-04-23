<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupon__users', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('id_coupon')->unsigned();
            $table->foreign('id_coupon')
                  ->references('id')->on('coupons');

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
        Schema::dropIfExists('coupon__users');
    }
}
