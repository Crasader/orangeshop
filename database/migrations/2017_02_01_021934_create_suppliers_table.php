<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->increments('supplier_id');
            $table->string('name')->comment('姓名');
            $table->string('mobile')->comment('电话');
            $table->string('qq')->comment('qq');
            $table->string('wechat')->comment('wechat');
            $table->string('description')->comment('描述');
            $table->tinyInteger('state')->comment('状态 0-禁用 1-启用');
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
        Schema::dropIfExists('suppliers');
    }
}
