<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('article_id');
            $table->tinyInteger('cate_id')->comment('从属分类id');
            $table->string('title')->comment('文章标题');
            $table->string('author')->comment('作者');
            $table->string('keyword')->comment('关键字');
            $table->string('description')->comment('描述');
            $table->string('content')->comment('内容');
            $table->string('thumb')->comment('文章缩略图');

            $table->integer('num_view')->comment('查看数');
            $table->integer('num_approved')->comment('点赞数');
            $table->tinyInteger('state')->comment('状态 0-关闭 1-开启');
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
        Schema::dropIfExists('articles');
    }
}
