<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProviderProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_project', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('provider_id')->default(0)->comment('对应供应商表ID');
            $table->string('name', 50)->default('')->comment('项目名称');
            $table->string('developer_name', 50)->default('')->comment('开发商名称');
            $table->integer('province_id')->default(0)->comment('省份ID');
            $table->integer('city_id')->default(0)->comment('城市ID');
            $table->timestamp('time')->default('0000-00-00 00:00:00')->comment('合同签订时间');
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
        Schema::dropIfExists('provider_project');
    }
}
