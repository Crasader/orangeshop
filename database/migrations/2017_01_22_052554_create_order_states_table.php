<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //未处理、已收款、已发货、已完成、取消订单，已过期
        Schema::create('order_states',function (Blueprint $table){
            $table->increments('state_id');
            $table->tinyInteger('state_code')->comment('订单状态 0-未处理、1-已收款、2-已发货、3-已完成、4-取消订单');
            $table->string('value')->comment('订单状态 0-未处理、1-已收款、2-已发货、3-已完成、4-取消订单');

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
        //
        Schema::dropIfExists('order_states');
    }
}
