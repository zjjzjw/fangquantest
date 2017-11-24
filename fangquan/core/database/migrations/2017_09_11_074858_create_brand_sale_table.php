<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandSaleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brand_sale', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 50)->default('')->comment('姓名');
            $table->integer('brand_id')->default(0)->comment('品牌id');
            $table->integer('type')->default(0)->comment('类别：1=公司销售负责人 2=区域销售负责人');
            $table->string('telphone', 20)->default('')->comment('联系电话');
            $table->integer('status')->default(0)->comment('类型');
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
        Schema::drop('brand_sale');
    }
}
