<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->increments('address_id');
            $table->integer('user_id')->comment('用户id');
            $table->string('consignee')->comment('收件人');
            $table->string('mobile')->comment('收件人电话');
            //$table->integer('country')->default(0)->comment('国家id');
            $table->integer('province_id')->nullable()->comment('省份id');
            $table->integer('city_id')->nullable()->comment('城市id');
            $table->string('district_id')->nullable()->comment('地区');
            $table->string('address')->nullable()->comment('地址');
            $table->string('zipcode')->default('000000')->comment('邮编');

            $table->tinyInteger('is_default')->default(0)->comment('是否是默认收件地址');

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
        Schema::dropIfExists('addresses');
    }
}
