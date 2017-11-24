<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateInformationBrandTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('information_brand', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('information_id')->default(0)->comment('资讯ID');
            $table->integer('brand_id')->default(0)->comment('品牌ID');
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
        Schema::drop('information_brand');
    }
}
