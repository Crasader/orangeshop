<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('attributes', function (Blueprint $table) {
            $table->increments('attr_id');
            $table->string('name')->comment('属性名称');
            $table->tinyInteger('is_filter')->comment('是否为筛选属性');
            $table->tinyInteger('show_type')->comment('展示类型 0-文字 1-css块,2-图片');
            $table->tinyInteger('state')->default(1)->comment('状态');
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
        Schema::dropIfExists('attributes');
    }
}
