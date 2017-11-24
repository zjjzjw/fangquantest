<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductParamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_param', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('product_id')->default(0)->comment('产品ID');
            $table->integer('category_param_id')->default(0)->comment('对应品类参数id');
            $table->string('name')->default('')->comment('参数名');
            $table->string('value')->default('')->comment('参数值');
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
        Schema::drop('product_param');
    }
}
