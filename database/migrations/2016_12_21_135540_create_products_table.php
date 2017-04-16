<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('pid');
            // 1、基本信息
            $table->string('name');
            $table->smallInteger('cate_id')->index()->comment('分类id');
            $table->string('brand_id')->index()->comment('品牌id');
            $table->integer('order')->comment('排序');
            $table->integer('weight')->comment('重量,g为单位');
            $table->integer('stock')->comment('库存量');
            $table->integer('stock_limit')->comment('预警');
            $table->decimal('cost_price')->comment('进价');
            $table->decimal('market_price')->comment('市场价');
            $table->decimal('shop_price')->comment('本店售价');
            $table->tinyInteger('state')->comment('状态 0-禁卖 1-开卖');
            $table->tinyInteger('is_best')->default(0)->comment('是否是精品');
            $table->tinyInteger('is_hot')->default(0)->comment('是否是热销');
            $table->tinyInteger('is_new')->default(0)->comment('是否是新品');
            $table->tinyInteger('is_free_shipping')->default(1)->comment('是否免邮');
            //$table->tinyInteger('is_on_sale')->default(1)->comment('是否上架');
            //$table->dateTime('on_time')->comment('上架时间');
            // 2、详细描述
            $table->text('description')->comment('描述');
            $table->string('keywords')->comment('关键字');


            // 3、图片相册 images表
            // 4、商品属性 attributes表
            // 5、关联商品 relate表
            // 6、关联文章 articles表

            $table->integer('sale_count')->default(0)->comment('销售数量');
            $table->integer('visit_count')->default(0)->comment('访问数量');
            $table->integer('review_count')->default(0)->comment('评论数量');

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
        Schema::dropIfExists('products');
    }
}
