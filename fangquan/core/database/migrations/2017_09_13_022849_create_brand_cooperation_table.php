<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandCooperationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brand_cooperation', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('brand_id')->default(0)->comment('品牌id');
            $table->integer('developer_id')->default(0)->comment('开发商');
            $table->string('deadline', 50)->default('')->comment('战略期限');
            $table->tinyInteger('is_exclusive')->default(0)->comment('是否独家1=是 2-否');
            $table->integer('status')->default(0)->comment('状态');
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
        Schema::drop('brand_cooperation');
    }
}
