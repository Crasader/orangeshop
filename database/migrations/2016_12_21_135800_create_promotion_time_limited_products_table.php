<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromotionTimeLimitedProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('promotion_time_limited_products',function(Blueprint $table){
            $table->increments('record_id')->comment('自增id');
            $table->integer('pid')->comment('商品id');
            $table->tinyInteger('on_sale_state')->comment('上架状态 0-无需上架 1-等待执行上架 2-已经执行上架)');
            $table->tinyInteger('out_sale_state')->comment('下架状态 0-无需下架 1-等待执行下架 2-已经执行下架)');
            $table->dateTime('on_sale_time')->comment('上架时间');
            $table->dateTime('out_sale_time')->comment('下架时间');

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
        Schema::dropIfExists('promotion_time_limited_products');
    }
}
