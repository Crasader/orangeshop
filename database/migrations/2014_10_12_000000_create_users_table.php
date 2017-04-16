<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->nullable();
            $table->string('email')->nullable();
            $table->string('password');
            $table->string('avatar')->default('/index/images/getAvatar.do.jpg');
            $table->string('mobile')->nullable();
            $table->tinyInteger('verify_email')->default(0)->comment('是否邮箱验证');
            $table->tinyInteger('verify_mobile')->default(0)->comment('是否手机验证');
            $table->integer('level_id')->default(0)->comment('用户等级id');

            $table->dateTime('last_visit_time')->nullable()->comment('上次登录时间');
            $table->string('last_visit_ip')->nullable()->comment('上次访问的ip');
            $table->string('register_ip')->nullable()->comment('注册时的ip');
            $table->string('register_rg_id')->nullable()->comment('注册区域');
            $table->tinyInteger('sex')->default(1)->comment('性别， 0-男 1-女');
            $table->tinyInteger('state')->default(1)->comment('状态 0-禁止登陆 1-允许登录');

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
