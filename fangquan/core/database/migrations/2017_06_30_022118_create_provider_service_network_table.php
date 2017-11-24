<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 服务网点
 * Class CreateProviderServiceNetworkTable
 */
class CreateProviderServiceNetworkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_service_network', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 50)->default('')->comment('网点名称');
            $table->bigInteger('provider_id')->default(0)->comment('供应商ID');
            $table->integer('province_id')->default(0)->comment('省份ID');
            $table->integer('city_id')->default(0)->comment('城市ID');
            $table->string('address', 255)->default('')->comment('地址');
            $table->integer('worker_count')->default(0)->comment('员工人数');
            $table->string('contact', 16)->default('')->comment('联系人');
            $table->string('telphone', 32)->default('')->comment('电话号码');
            $table->tinyInteger('status')->default(0)->comment('状态 1=待审核 2=审核通过 3=审核驳回');
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
        Schema::dropIfExists('provider_service_network');
    }
}
