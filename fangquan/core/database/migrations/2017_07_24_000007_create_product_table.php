<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('brand_id')->default(0)->comment('品牌ID');
            $table->integer('product_category_id')->default(0)->comment('品类ID');
            $table->string('product_model')->default('')->comment('产品型号');
            $table->decimal('price', 11, 2)->default(0)->comment('面价');
            $table->integer('created_user_id')->default(0)->comment('创建者ID');
            $table->integer('logo')->default(0)->comment('封面');
            $table->integer('comment_count')->default(0)->comment('评论数');
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
        Schema::drop('product');
    }
}
