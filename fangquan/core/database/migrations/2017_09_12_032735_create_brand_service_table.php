<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brand_service', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('brand_id')->default(0)->comment('品牌标识');
            $table->string('service_range', 50)->default('')->comment('服务范围');
            $table->string('warranty_range', 50)->default('')->comment('质保期限');
            $table->string('supply_cycle', 255)->default('')->comment('产品供货周期');
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
        Schema::dropIfExists('brand_service');
    }
}
