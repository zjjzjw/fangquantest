<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 合作供应商
 * Class CreateProviderFriend
 */
class CreateProviderFriend extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('provider_friend', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('provider_id')->default(0)->comment('供应商id');
            $table->string('name', 50)->default('')->comment('开发商名称');
            $table->integer('logo')->default(0)->comment('关联的图片表id');
            $table->tinyInteger('status')->default(0)->comment('状态 1=待审核 2=审核通过 3=审核驳回');
            $table->string('link')->default('')->comment("跳转到站外地址");
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
        Schema::dropIfExists('provider_friend');
    }
}
