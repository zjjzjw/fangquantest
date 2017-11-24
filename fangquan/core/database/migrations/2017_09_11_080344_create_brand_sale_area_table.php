<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandSaleAreaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brand_sale_area', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('brand_sale_id')->default(0)->comment('品牌id');
            $table->integer('area_id')->default(0)->comment('区域id');
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
        Schema::drop('brand_sale_area');
    }
}
