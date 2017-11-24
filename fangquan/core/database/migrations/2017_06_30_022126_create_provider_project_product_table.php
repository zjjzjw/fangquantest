<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProviderProjectProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_project_product', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('provider_project_id')->default(0)->comment('对应历史项目表ID');
            $table->string('name', 50)->default('')->comment('产品名称');
            $table->integer('num')->default(0)->comment('数量');
            $table->integer('measureunit_id')->default(0)->comment('对应单位表ID');
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
        Schema::dropIfExists('provider_project_product');
    }
}
