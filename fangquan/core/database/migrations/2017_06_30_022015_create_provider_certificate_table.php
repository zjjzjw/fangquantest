<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 企业证书
 * Class CreateProviderCertificateTable
 */
class CreateProviderCertificateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_certificate', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('provider_id')->default(0)->comment('供应商ID');
            $table->string('name', 50)->default('')->comment('证书名称');
            $table->bigInteger('image_id')->default(0)->comment('图片资源ID');
            $table->tinyInteger('type')->default(1)->comment('类型 1=资质证书 2=专利证书 3=荣誉证书');
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
        Schema::dropIfExists('provider_certificate');
    }
}
