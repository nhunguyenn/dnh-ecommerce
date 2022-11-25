<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateReturnOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('return_order', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_purchase')->unsigned();
            $table->integer('active')->default(0)->comment('[
                0 => Chờ Xác Nhận Trả Hàng và Hoàn Tiền,
                1 => Xác Nhận Trả Hàng và Hoàn Tiền,
                2 => Từ Chối Xác Nhận Trả Hàng và Hoàn Tiền (table purchase: active_return = 0 và active_confirm = 1),

                if(active == 1) Kho vận có chức năng xác nhận đã nhận hàng trả về: active = 3
                if(active == 3) Nhân viên bán hàng có chức năng xác nhận hoàn tiền: active = 4
            ]');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->foreign('id_purchase')->references('id')->on('purchase');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('return_order');
    }
}
