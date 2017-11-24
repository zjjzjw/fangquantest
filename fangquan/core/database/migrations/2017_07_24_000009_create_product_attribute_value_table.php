<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductAttributeValueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_attribute_value', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('product_id')->default(0)->comment('产品ID');
            $table->integer('attribute_id')->default(0)->comment('属性ID');
            $table->integer('value_id')->default(0)->comment('属性值ID');
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
        Schema::drop('product_attribute_value');
    }
}
