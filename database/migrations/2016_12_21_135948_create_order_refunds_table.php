<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderRefundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('order_refunds',function (Blueprint $table){
            $table->increments('refund_id')->comment('退款id');
            $table->string('refund_sn')->comment('退款编号，自动生成');

            $table->integer('order_id')->comment('订单id');
            $table->integer('uid')->comment('用户id');
            $table->dateTime('apply_time')->comment('申请时间');
            $table->decimal('user_pay_money')->comment('用户支付的金额');

            $table->decimal('refund_money')->comment('应该退款金额');
            $table->integer('refund_payment_id')->comment('退款支付系统id');
            $table->dateTime('refund_time')->comment('退款时间');
            $table->string('refund_pay_sn')->comment('支付单号');

            $table->tinyInteger('state')->comment('状态');
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
        Schema::dropIfExists('order_refunds');
    }
}
