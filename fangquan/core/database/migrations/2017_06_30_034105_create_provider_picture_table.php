<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProviderPictureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_picture', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('provider_id')->default(0)->comment('供应商ID');
            /** ProviderImageType  */
            $table->tinyInteger('type')->default(0)->comment('类型');
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
        Schema::dropIfExists('provider_picture');
    }
}
