<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProviderProductProgrammeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_product_programme', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 100)->default('')->comment('标题');
            $table->text('desc')->default('')->comment('方案详情');
            $table->integer('provider_id')->default(0)->comment('供应商id');
            $table->tinyInteger('status')->default(0)->comment('状态 1=显示 2=隐藏');
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
        Schema::drop('provider_product_programme');
    }
}
