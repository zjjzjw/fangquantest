<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppVersionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_version', function (Blueprint $table) {
            $table->integer('id');
            $table->tinyInteger('device')->default(0)->comment('设备 1-Android；2-iOS');
            $table->integer('version_code')->default(0)->comment('版本code，用于android版本比较');
            $table->string('version_name')->default('')->comment('版本号');
            $table->string('change')->default('')->comment('版本变更内容');
            $table->bigInteger('resource_id')->default(0)->comment('下载地址,源表id');
            $table->string('size', 50)->default('')->comment('安装包大小，单位字节M');
            $table->tinyInteger('force_upgrade')->default(0)->comment('是否强制升级 1-是；2-否');
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
        Schema::dropIfExists('app_version');
    }
}
