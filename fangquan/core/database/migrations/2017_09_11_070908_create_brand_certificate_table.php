<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandCertificateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brand_certificate', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 50)->default('')->comment('名称');
            $table->integer('brand_id')->default(0)->comment('品牌id');
            $table->integer('type')->default(0)->comment('类别：1=强制认证证书 2=管理体系认证证书 3=环境标志认证证书');
            $table->integer('certificate_file')->default(0)->comment('证书附件');
            $table->integer('status')->default(0)->comment('类型');
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
        Schema::drop('brand_certificate');
    }
}
