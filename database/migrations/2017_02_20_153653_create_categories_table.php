<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            // These columns are needed for Baum's Nested Set implementation to work.
            // Column names may be changed, but they *must* all exist and be modified
            // in the model.
            // Take a look at the model scaffold comments for details.
            // We add indexes on parent_id, lft, rgt columns by default.
            $table->increments('cate_id');
            $table->integer('parent_id')->nullable()->index();
            $table->integer('lft')->nullable()->index();
            $table->integer('rgt')->nullable()->index();
            $table->integer('depth')->nullable();

            // Add needed columns here (f.ex: name, slug, path, etc.)
            $table->string('name')->comment('分类名称');
            $table->string('price_range')->nullable()->comment('价格区间,用换行分割');
            $table->string('description')->nullable()->comment('分类描述');
            $table->string('keywords')->nullable()->comment('分类关键字');
            $table->integer('is_show')->default(1)->comment('是否显示');
            $table->integer('is_nav')->default(0)->comment('显示在导航栏');
            $table->string('url')->nullable()->comment('自定义链接');
            $table->string('logo_path')->nullable()->comment('图标');
            $table->tinyInteger('state')->default(1)->comment('状态');
            $table->integer('order')->default(0)->comment('排序');

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
        Schema::drop('categories');
    }

}
