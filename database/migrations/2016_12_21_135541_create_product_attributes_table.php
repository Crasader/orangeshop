<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('product_attributes',function (Blueprint $table){
            $table->increments('record_id')->comment('记录id');
            $table->integer('pid')->comment('商品id');
            $table->smallInteger('attr_id')->comment('属性id');
            $table->integer('attr_value_id')->comment('属性值id');
            $table->decimal('add_money')->default(0)->comment('附加钱');
            //$table->integer('order')->comment('排序');
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
        Schema::dropIfExists('product_attributes');
    }
}
