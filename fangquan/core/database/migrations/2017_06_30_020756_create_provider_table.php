<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 供应商
 * Class CreateProviderTable
 */
class CreateProviderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('company_name', 50)->default('')->comment('企业名称');
            $table->string('brand_name', 50)->default('')->comment('品牌名称');
            $table->integer('patent_count')->default(0)->comment('专利数');
            $table->integer('favorite_count')->default(0)->comment('收藏次数');
            $table->integer('product_count')->default(0)->comment('产品数量');
            $table->integer('project_count')->default(0)->comment('项目数量');
            $table->integer('province_id')->default(0)->comment('省份ID');
            $table->integer('city_id')->default(0)->comment('城市ID');
            $table->string('operation_address', 128)->default('')->comment('经营地址');
            $table->integer('produce_province_id')->default(0)->comment('生产地址省份ID');
            $table->integer('produce_city_id')->default(0)->comment('生产地址城市ID');
            $table->string('produce_address', 128)->default('')->comment('生产地址');
            $table->string('telphone', 32)->default('')->comment('电话号码');
            $table->string('fax', 32)->default('')->comment('传真');
            $table->string('service_telphone', 32)->default('')->comment('服务热线');
            $table->string('website', 255)->default('')->comment('企业网站');
            $table->tinyInteger('operation_mode')->default(0)->comment('经营模式');
            $table->integer('founding_time')->default(0)->comment('成立时间');//年
            $table->integer('turnover')->default(0)->comment('年营业额万元');
            $table->decimal('registered_capital', 15, 2)->default(0)->comment('注册资金');
            $table->integer('worker_count')->default(0)->comment('员工人数');
            $table->text('summary')->default('')->comment('企业简介');
            $table->string('corp', 50)->default('')->comment('公司法人');
            $table->tinyInteger('score_scale')->default(0)->comment('企业规模分数');
            $table->tinyInteger('score_qualification')->default(0)->comment('行业资质分数');
            $table->tinyInteger('score_credit')->default(0)->comment('企业信用分数');
            $table->tinyInteger('score_innovation')->default(0)->comment('创新能力分数');
            $table->tinyInteger('score_service')->default(0)->comment('服务体系分数');
            $table->string('contact', 50)->default('')->comment('联系人');
            $table->integer('integrity')->default(0)->comment('资料完整度');
            $table->integer('rank')->default(0)->comment('供应商排名');
            $table->tinyInteger('status')->default(1)->comment('供应商状态');
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
        Schema::dropIfExists('provider');
    }
}
