<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvertisementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertisement', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->default('')->comment('标题');
            $table->integer('image_id')->default(0)->comment('图片id');
            $table->integer('position')->default(0)->comment('广告位');
            $table->integer('type')->default(0)->comment('类型');
            $table->string('link')->default('')->comment('链接');
            $table->integer('sort')->default(0)->comment('排序');
            $table->tinyInteger('status')->default(0)->comment('状态：1=显示 2=隐藏');
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
        Schema::dropIfExists('advertisement');
    }
}
