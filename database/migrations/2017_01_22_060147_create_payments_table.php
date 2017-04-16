<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('payment_id');
            $table->string('name')->comment('支付系统名');
            $table->string('code')->comment('支付code');
            $table->decimal('fee')->comment('手续费');
            $table->tinyInteger('enabled')->comment('是否开启 0-关闭 1-开启');
            $table->text('config')->comment('配置');
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
        Schema::dropIfExists('payments');
    }
}
