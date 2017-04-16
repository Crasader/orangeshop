<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('message_id');
            $table->integer('admin_id')->comment('发送者id');
            $table->string('content')->comment('消息内容');
            $table->tinyInteger('type')->comment('类型 0-全体消息 1-个人消息');
            $table->tinyInteger('category')->comment('0-系统消息 1-活动消息');
            $table->dateTime('send_time')->comment('发送时间');
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
        Schema::dropIfExists('messages');
    }
}
