<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFriendlyLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('friendly_links', function (Blueprint $table) {
            $table->increments('link_id');
            $table->string('link_name')->comment('连接名');
            $table->string('link_url')->comment('连接的url');
            $table->string('link_logo')->comment('连接的logo');
            $table->tinyInteger('is_show')->comment('是否显示');
            $table->tinyInteger('target_type')->comment('打开方式 1-新窗口 0-原窗口');
            $table->integer('order')->comment('排序');
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
        Schema::dropIfExists('friendly_links');
    }
}
