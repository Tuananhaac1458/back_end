<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('code_invoice')->unique();
            $table->string('userName_invoice')->nullable();
            $table->string('userPhone_invoice',15)->nullable();
            $table->string('address_invoice')->nullable();
            $table->string('address_value_invoice')->nullable();
            $table->string('noteDriver_invoice')->nullable();
            $table->string('noteStaff_invoice')->nullable();
            $table->decimal('totalMonney',11,2)->nullable();
            $table->decimal('money_driver',11,2)->nullable();
            $table->decimal('realMoney',11,2)->nullable();
            $table->string('status')->nullable();

            $table->bigInteger('id_coupon')->unsigned()->nullable();;
            $table->foreign('id_coupon')
                    ->references('id')->on('coupons');

            $table->bigInteger('id_store')->unsigned()->nullable();;
            $table->foreign('id_store')
                    ->references('id')->on('stores');        
            
            $table->bigInteger('id_user')->unsigned();
            $table->foreign('id_user')
                    ->references('id')->on('users');
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
        Schema::dropIfExists('invoices');
    }
}
