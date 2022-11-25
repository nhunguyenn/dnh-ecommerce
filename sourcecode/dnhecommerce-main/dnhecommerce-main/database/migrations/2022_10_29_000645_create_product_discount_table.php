<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateProductDiscountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_discount', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_product')->unsigned();
            $table->integer('percent_discount')->default(0);
            $table->integer('quantity')->default(0);
            $table->text('note')->nullable();
            $table->integer('active')->default(0);
            $table->date('time_start');
            $table->date('time_end');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->foreign('id_product')->references('id')->on('product');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_discount');
    }
}
