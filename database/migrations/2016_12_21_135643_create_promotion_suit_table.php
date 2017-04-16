<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromotionSuitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('promotion_suit',function(Blueprint $table){
            $table->increments('pm_id');
            $table->string('name');
            $table->string('start_time')->comment('开始时间');
            $table->string('end_time')->comment('结束时间');
            $table->tinyInteger('state')->default(1)->comment('状态 0-关闭 1-开启');

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
        Schema::dropIfExists('promotion_suit');
    }
}
