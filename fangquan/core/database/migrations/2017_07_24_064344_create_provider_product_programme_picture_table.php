<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProviderProductProgrammePictureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_product_programme_picture', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('programme_id')->default(0)->comment('对应方案表ID');
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
        Schema::dropIfExists('provider_product_programme_picture');
    }
}
