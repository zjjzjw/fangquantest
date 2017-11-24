<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brand', function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->string('brand_name')->default('')->comment('品牌名称');
            $table->integer('logo')->default(0)->comment('品牌logo');
            $table->string('company_name')->default('')->comment('公司名称');
            $table->integer('company_type')->default(0)->comment('公司类型');
            $table->integer('province_id')->default(0)->comment('省ID');
            $table->integer('city_id')->default(0)->comment('市ID');
            //企业信息
            $table->string('corp', 50)->default('')->comment('法人');
            $table->tinyInteger('operation_mode')->default(0)->comment('经验模式');
            $table->integer('domestic_import')->default(0)->comment('国产/进口');
            $table->timestamp('founding_time')->default('0000-00-00 00:00:00')->comment('成立时间');
            $table->decimal('registered_capital', 15, 2)->default(0)->comment('注册资金');
            $table->integer('turnover')->default(0)->comment('年营业额');
            $table->integer('worker_count')->default(0)->comment('员工人数');
            $table->integer('comment_count')->default(0)->comment('评论数');
            $table->string('produce_address')->default('')->comment('生产地址');
            $table->string('operation_address')->default('')->comment('经营地址');
            $table->text('summary')->default('')->comment('企业简介');
            $table->string('telphone')->default('')->comment('联系电话');
            $table->decimal('avg_price', 11, 2)->defautl(0)->comment('均价');

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
        Schema::drop('brand');
    }
}
