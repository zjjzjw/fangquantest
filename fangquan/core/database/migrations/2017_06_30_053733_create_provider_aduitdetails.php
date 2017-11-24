<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 验厂报告
 * Class CreateProviderAduitdetails
 */
class CreateProviderAduitdetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('provider_aduitdetails', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('provider_id')->default(0)->comment('供应商id');
            $table->tinyInteger('type')->default(0)->comment('类型 1=房圈提供的验厂报告 2=第三方提供的验厂报告');
            $table->string('name', 50)->default('')->comment('名称');
            $table->integer('link')->default(0)->comment('对应resource表的id');
            $table->string('filename')->default('')->comment('文件名');
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
        //
        Schema::dropIfExists('provider_aduitdetails');
    }
}
