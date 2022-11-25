<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCartProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_product', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_customer')->unsigned();
            $table->integer('id_product')->unsigned();
            $table->integer('id_size')->unsigned();
            $table->integer('id_color')->unsigned();
            $table->integer('quantity_product')->default(1);
            $table->integer('status')->default(0);
            $table->integer('active')->default(1);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->foreign('id_customer')->references('id')->on('customer');
            $table->foreign('id_product')->references('id')->on('product');
            $table->foreign('id_size')->references('id')->on('product_size');
            $table->foreign('id_color')->references('id')->on('product_color');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cart_product');
    }
}
