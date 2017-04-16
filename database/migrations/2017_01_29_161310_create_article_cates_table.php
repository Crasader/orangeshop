<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleCatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_cates', function (Blueprint $table) {
            $table->increments('cate_id');
            $table->string('name');
            $table->tinyInteger('show_in_nav')->comment('是否在导航中显示');
            $table->string('description')->comment('描述');
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
        Schema::dropIfExists('article_cates');
    }
}
