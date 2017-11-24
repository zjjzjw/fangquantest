<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductDynamicParamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_dynamic_param', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->default(0)->comment('产品标示');
            $table->string('param_name', 50)->default('')->comment('参数名称');
            $table->string('param_value', 50)->default('')->comment('参数值');
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
        Schema::dropIfExists('product_dynamic_param');
    }
}
