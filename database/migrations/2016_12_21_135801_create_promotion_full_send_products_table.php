<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromotionFullSendProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('promotion_full_send_products',function(Blueprint $table){
            $table->increments('record_id')->comment('记录id');
            $table->integer('pm_id')->comment('促销活动id');
            $table->integer('pid')->comment('商品id');
            $table->tinyInteger('type')->default(0)->comment('类型 0-赠品 1-主商品)');
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
        Schema::dropIfExists('promotion_full_send_products');
    }
}
