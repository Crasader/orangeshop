<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->increments('coupons_id');
            $table->string('name')->comment('优惠券名字');
            $table->decimal('money')->comment('优惠券面值');
            $table->decimal('condition')->comment('使用最低限额,指的是总金额');

            $table->integer('num_total')->comment('总数量');
            $table->integer('num_received')->comment('发放数量');
            $table->integer('num_used')->comment('被使用的的数量');

            $table->dateTime('receive_start_time')->comment('允许领取的开始时间');
            $table->dateTime('receive_end_time')->comment('允许领取的结束时间');
            $table->dateTime('use_start_time')->comment('允许使用的开始时间');
            $table->dateTime('use_end_time')->comment('允许使用的结束时间');

            $table->integer('order')->comment('排序');
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
        Schema::dropIfExists('coupons');
    }
}
