<?php

use Carbon\Carbon;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('admins', function(Blueprint $table) {
            $table->increments('user_id');
            $table->string('username');
            $table->string('email')->unique();
            $table->string('password');
            $table->tinyInteger('is_super')->default(0)->comment('是否是超级管理员');
            $table->string('mobile')->nullable();
            $table->tinyInteger('verify_email')->default(0)->comment('是否邮箱验证');
            $table->tinyInteger('verify_mobile')->default(0)->comment('是否手机验证');
            $table->tinyInteger('state')->default(0)->comment('状态');

            $table->dateTime('last_visit_time')->default(Carbon::now())->comment('上次登录时间');
            $table->string('last_visit_ip')->comment('上次访问的ip');

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
        Schema::dropIfExists('admins');
	}

}
