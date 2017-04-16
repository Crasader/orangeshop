<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images',function (Blueprint $table){
            $table->increments('img_id')->comment('商品图片id');
            $table->integer('pid')->comment('商品id');
            $table->string('path')->comment('图片的路径');
            $table->tinyInteger('is_main')->comment('是否为产品的主图');
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
        //
        Schema::dropIfExists('images');
    }
}
