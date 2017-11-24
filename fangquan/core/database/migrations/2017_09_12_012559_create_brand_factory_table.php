<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandFactoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brand_factory', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('brand_id')->default(0)->comment('品牌id');
            $table->integer('factory_type')->default(0)->comment('厂家类型1=总厂 2=分厂');
            $table->integer('province_id')->default(0)->comment('省ID');
            $table->integer('city_id')->default(0)->comment('市ID');
            $table->string('production_area', 50)->default('')->comment('生产面积');
            $table->string('address', 100)->default('')->comment('地址');
            $table->integer('status')->default(0)->comment('状态');
            $table->softDeletes();
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
        Schema::dropIfExists('brand_factory');
    }
}
