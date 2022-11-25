<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_address')->unsigned();
            $table->string('id_cart_product');
            $table->string('id_product_discount')->nullable();
            $table->integer('id_voucher')->nullable()->unsigned();
            $table->integer('id_delivery')->unsigned();
            $table->integer('active')->default(0)->comment('[
                0 => Chờ Xác Nhận,
                1 => Chờ Lấy Hàng,
                2 => Đang Giao Hàng,
                3 => Đã Giao Hàng,
                4 => Đơn Hủy,
            ]');
            $table->date('date_unpaid')->nullable();
            $table->date('date_toship')->nullable();
            $table->date('date_shipping')->nullable();
            $table->date('date_completed')->nullable();
            $table->date('date_cancelled')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->foreign('id_address')->references('id')->on('address');
            $table->foreign('id_voucher')->references('id')->on('voucher');
            $table->foreign('id_delivery')->references('id')->on('delivery');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order');
    }
}
