<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoupanDeveloperTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loupan_developer', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('loupan_id')->default(0)->comment('楼盘ID');
            $table->integer('developer_id')->default(0)->comment('开发商ID');
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
        Schema::dropIfExists('loupan_developer');
    }
}
