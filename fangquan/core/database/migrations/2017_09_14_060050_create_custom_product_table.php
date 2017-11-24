<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_product', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('brand_id')->default(0)->comment('品牌标识');
            $table->integer('developer_id')->default(0)->comment('开发商标识');
            $table->integer('loupan_id')->default(0)->comment('楼盘标识');
            $table->string('product_name')->default('')->comment('产品名称');
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
        Schema::dropIfExists('custom_product');
    }
}
