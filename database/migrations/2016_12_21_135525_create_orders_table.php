<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('orders',function(Blueprint $table){
            $table->increments('oid');
            $table->string('osn')->comment('订单编号');
            $table->integer('uid')->comment('用户id');

            $table->tinyInteger('state_code_id')->default(0)->comment('订单状态码');

            $table->decimal('product_amount')->comment('商品合计');
            $table->decimal('order_amount')->comment('订单合计');
            $table->decimal('coupon_price')->comment('优惠券面值');
            $table->decimal('surplus_money')->comment('金付金额');
            $table->integer('parent_id')->comment('父id');

            $table->integer('shipping_id')->comment('物流系统id');
            $table->string('shipping_sn')->comment('配送单号');
            $table->dateTime('shipping_time')->comment('配送时间');

            $table->integer('pay_id')->comment('支付系统id');
            $table->string('pay_sn')->comment('支付单号');
            $table->dateTime('pay_time')->comment('支付时间');

            $table->smallInteger('region_id')->comment('区域id');
            $table->string('consignee')->comment('收货人');
            $table->string('mobile')->comment('手机');
            $table->string('code')->comment('邮编');
            $table->string('address')->comment('收货地址');

            $table->decimal('ship_fee')->comment('配送费用');
            $table->decimal('full_cut')->comment('满减金额');
            $table->decimal('discount')->comment('折扣');

            $table->string('remark')->comment('卖家备注');
            $table->string('ip')->comment('下单ip');

            $table->timestamps();
            $table->softDeletes();
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
        Schema::dropIfExists('orders');
    }
}
