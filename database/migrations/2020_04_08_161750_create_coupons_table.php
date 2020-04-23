<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code_coupon')->unique();
            $table->string('title_coupon')->nullable();
            $table->string('subtitle_coupon')->nullable();
            $table->string('condition_coupon')->nullable();
            $table->string('type_coupon')->nullable();
            $table->decimal('value_coupon',11,2)->nullable();
            $table->date('expiry_day')->nullable();
            $table->boolean('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupons');
    }
}
