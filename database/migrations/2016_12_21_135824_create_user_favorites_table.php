<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserFavoritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('user_favorites',function(Blueprint $table){
            $table->integer('uid')->comment('用户id');
            $table->integer('pid')->comment('商品id');
            $table->tinyInteger('state')->default(1)->comment('状态 0-删除 1-保留');
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
        Schema::dropIfExists('user_favorites');
    }
}
