<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProviderProjectPictureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_project_picture', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('provider_project_id')->default(0)->comment('对应历史项目表ID');
            $table->bigInteger('image_id')->default(0)->comment('图片资源ID');
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
        Schema::dropIfExists('provider_project_picture');
    }
}
