<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandSignListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brand_sign_list', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('brand_id')->default(0)->comment('品牌id');
            $table->integer('loupan_id')->default(0)->comment('楼盘id');
            $table->integer('province_id')->default(0)->comment('省ID');
            $table->integer('city_id')->default(0)->comment('市ID');
            $table->string('product_model')->default('')->comment('产品型号');
            $table->integer('delivery_num')->default(0)->comment('交付数量');
            $table->dateTime('order_sign_time')->default('0000-00-00 00:00:00')->comment('订单签订时间');
            $table->integer('status')->default(0)->comment('状态');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('brand_sign_list');
    }
}
