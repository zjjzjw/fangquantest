<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 宣传图片表
 * Class CreateProviderPropaganda
 */
class CreateProviderPropaganda extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('provider_propaganda', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('provider_id')->default(0)->comment('供应商id');
            $table->integer('image_id')->default(0)->comment('图片资源id');
            $table->string('link')->default('')->comment('跳转到站外地址');
            $table->tinyInteger('status')->default(0)->comment('状态: 1=待审核 2=审核通过 3=审核驳回');
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
        Schema::dropIfExists('provider_propaganda');
    }
}
