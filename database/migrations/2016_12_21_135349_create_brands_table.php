<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->increments('brand_id');
            $table->string('name');
            $table->integer('country_id')->comment('国家id');
            $table->tinyInteger('state')->default(1)->comment('状态');
            $table->string('logo_path')->comment('logo');
            $table->text('description')->comment('描述');
            $table->integer('order')->default(0)->comment('顺序');

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
        Schema::dropIfExists('brands');
    }
}
