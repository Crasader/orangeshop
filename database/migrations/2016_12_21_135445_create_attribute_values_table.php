<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributeValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('attribute_values',function (Blueprint $table){
            $table->increments('attr_value_id')->comment('主键');
            $table->integer('attr_id')->comment('属性id');
            $table->string('attr_value_0')->nullable()->comment('文本属性值');
            $table->string('attr_value_1')->nullable()->comment('css属性值');
            $table->string('attr_value_2')->nullable()->comment('图片属性值');
            $table->integer('order')->comment('同一attr_id对应的值的排序');

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
        Schema::dropIfExists('attribute_values');
    }
}
