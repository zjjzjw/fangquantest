<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProviderProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_product', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('provider_id')->default(0)->comment('对应供应商表的ID');
            $table->integer('product_category_id')->default(0)->comment('对应供应商表的分类ID');
            $table->string('name', 50)->default('')->comment('产品名称');
            $table->integer('views')->default(0)->comment('浏览量');
            $table->text('attrib')->default('')->comment('属性json');
            $table->tinyInteger('attrib_integrity')->default(0)->comment('属性完整度');
            $table->decimal('price_low', 11, 2)->default(0)->comment('最底参考价');
            $table->decimal('price_high', 11, 2)->default(0)->comment('最高参考价');
            $table->tinyInteger('status')->default(1)->comment('审核状态');
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
        Schema::dropIfExists('provider_product');
    }
}
