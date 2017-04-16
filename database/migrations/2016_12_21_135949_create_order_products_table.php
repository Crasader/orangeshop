<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('order_products',function(Blueprint $table){
            $table->increments('record_id')->comment('记录id');
            $table->integer('order_id')->nullable()->comment('支付订单id');

            $table->integer('uid')->comment('用户id');
            $table->integer('pid')->comment('商品id');
            $table->integer('cate_id')->comment('分类id');
            $table->integer('brand_id')->comment('品牌id');

            $table->string('name')->comment('商品名称');
            $table->string('img')->comment('商品展示图');
            $table->decimal('discount_price')->comment('商品折扣价');
            $table->decimal('cost_price')->comment('成本价');
            $table->decimal('shop_price')->comment('商城价');
            $table->integer('real_count')->comment('真实购买数量');
            $table->integer('buy_count')->comment('购买数量');
            $table->integer('send_count')->comment('发送数量');
            $table->integer('type')->comment('商品类型(0-普遍商品 1-普通商品赠品 2-套装商品赠品 3-套装商品 4-满赠商品)');
            $table->integer('number')->comment('数量');
            $table->integer('ext_code1')->nullable()->comment('普通商品时为单品促销活动id,赠品时为赠品促销活动id,套装商品时为套装促销活动id,满赠赠品时为满赠促销活动id');
            $table->integer('ext_code2')->nullable()->comment('普通商品时为买送促销活动id,赠品时为赠品赠送数量,套装商品时为套装商品数量');
            $table->integer('ext_code3')->nullable()->comment('普通商品时为赠品促销活动id,套装商品时为赠品促销活动id');
            $table->integer('ext_code4')->nullable()->comment('普通商品时为满赠促销活动id');
            $table->integer('ext_code5')->nullable()->comment('普通商品时为满减促销活动id');
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
        Schema::dropIfExists('order_products');
    }
}
