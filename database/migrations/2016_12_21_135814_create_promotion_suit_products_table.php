<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromotionSuitProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('promotion_suit_products',function (Blueprint $table){
            $table->increments('record_id')->comment('记录id');
            $table->integer('pm_id')->comment('促销活动id');
            $table->integer('pid')->comment('商品id');
            $table->float('discount')->comment('折扣值');
            $table->integer('number')->comment('数量');
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
        Schema::dropIfExists('promotion_suit_products');
    }
}
