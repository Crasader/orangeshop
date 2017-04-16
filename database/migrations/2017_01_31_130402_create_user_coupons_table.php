<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_coupons', function (Blueprint $table) {
            $table->integer('user_id')->comment('用户id');
            $table->integer('coupon_id')->comment('优惠券id');

            $table->dateTime('received_time')->comment('领取时间');
            //未使用 used_time = 0 || order_id = 0
            //已使用 order_id > 0 and used_time > 0
            //已过期 coupon.use_end_time < time()
            $table->dateTime('used_time')->comment('使用时间');
            $table->integer('order_id')->nullable()->comment('订单id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_coupons');
    }
}
