<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_supplier')->unsigned();
            $table->integer('id_tax')->unsigned();
            $table->integer('id_category')->unsigned();
            $table->integer('id_related')->unsigned();
            $table->string('name')->unique();
            $table->string('image');
            $table->integer('quantity')->default(0);
            $table->integer('cost')->default(0);
            $table->integer('price')->default(0);
            $table->integer('viewed')->default(0);
            $table->integer('active_sale')->default(0);
            $table->integer('active_purchase')->default(0);
            $table->text('note')->nullable();
            $table->integer('active')->default(1);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->foreign('id_supplier')->references('id')->on('supplier');
            $table->foreign('id_tax')->references('id')->on('tax');
            $table->foreign('id_category')->references('id')->on('category');
            $table->foreign('id_related')->references('id')->on('related_product');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product');
    }
}
