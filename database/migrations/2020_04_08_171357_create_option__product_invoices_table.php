<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOptionProductInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('option__product_invoices', function (Blueprint $table) {
            $table->id();
            
            $table->string('id_product_invoice')->nullable();
            $table->string('option_name')->nullable();
            $table->decimal('price_option',11,2)->nullable();
            $table->boolean('type')->nullable();

            $table->bigInteger('id_invoice')->unsigned();
            $table->foreign('id_invoice')
                  ->references('id')->on('invoices');


            $table->bigInteger('id_product')->unsigned();
            $table->foreign('id_product')
                  ->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('option__product_invoices');
    }
}
