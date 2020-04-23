<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice__products', function (Blueprint $table) {
            $table->id();
            $table->string('id_product_invoice')->nullable();
            $table->decimal('amount',2,0)->nullable();

            $table->bigInteger('id_invoice')->unsigned();
            $table->foreign('id_invoice')
                  ->references('id')->on('invoices');

            $table->bigInteger('id_product')->unsigned();
            $table->foreign('id_product')
                  ->references('id')->on('products');
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
        Schema::dropIfExists('invoice__products');
    }
}
