<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('comment_id');
            $table->integer('parent_id')->comment('回复的上级id');
            $table->string('user_id')->comment('评论人id');
            //晒单图 关联到images表
            $table->string('commentable_type')->comment('可能是product、article');
            $table->string('commentable_id')->comment('可能是product_id、article_id');
            $table->string('content')->comment('内容');

            //如果是product的评论
            $table->tinyInteger('product_level')->comment('产品等级 0-4');
            $table->tinyInteger('service_level')->commet('卖家服务等级 0-4');
            $table->tinyInteger('deliver_level')->commet('物流等级 0-4');

            $table->integer('num_approved')->default(0)->comment('点赞数');
            $table->string('ip')->comment('评论人的ip');
            $table->tinyInteger('is_show')->comment('是否显示 0-不显示 1-显示');
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
        Schema::dropIfExists('comments');
    }
}
