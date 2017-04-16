<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserSearchHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('user_search_histories',function(Blueprint $table){
            $table->increments('record_id');
            $table->integer('uid')->comment('用户id');
            $table->string('word')->comment('搜索词');
            $table->integer('times')->comment('搜索次数');
            $table->dateTime('update_time')->comment('最后搜索时间');
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
        Schema::dropIfExists('user_search_histories');
    }
}
