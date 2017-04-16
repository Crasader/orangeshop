<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_configs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('字段名');
            $table->string('value')->comment('对应值');
            $table->string('group')->comment('所属分组');
            $table->string('description')->comment('描述');

            $table->tinyInteger('order')->comment('排序');
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
        Schema::dropIfExists('shop_configs');
    }
}
