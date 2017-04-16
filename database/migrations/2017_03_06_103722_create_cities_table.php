<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pid');
            $table->string('name');
            $table->tinyInteger('level')->comment('1：全部的省数据 2:全部的市数据 3:全部的县数据 4:全部的镇数据');
            $table->tinyInteger('province_level')->comment('是否直辖城市 0-否 1-是');
            $table->tinyInteger('use_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cities');
    }
}
