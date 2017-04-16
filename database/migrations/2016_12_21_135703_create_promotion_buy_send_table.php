<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromotionBuySendTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('promotion_buy_send',function(Blueprint $table){
            $table->increments('pm_id');
            $table->string('name');
            $table->dateTime('start_time')->comment('开始时间');
            $table->dateTime('end_time')->comment('结束时间');
            $table->tinyInteger('type')->comment('类型(0-全场参加,1-部分商品参加,2-部分商品不参加');
            $table->tinyInteger('buy_count')->comment('购买数量');
            $table->tinyInteger('send_count')->comment('赠送数量');

            $table->tinyInteger('state')->default(0)->comment('状态');
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
        Schema::dropIfExists('promotion_buy_send');
    }
}
