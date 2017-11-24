<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProviderBusinessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_business', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('provider_id')->default(0)->comment('供应商id');
            $table->longText('base_info')->default('')->comment('基础信息');
            $table->longText('main_person')->default('')->comment('主要人员');
            $table->longText('shareholder_info')->default('')->comment('股东信息');
            $table->longText('change_record')->default('')->comment('变更记录');
            $table->longText('branchs')->default('')->comment('分支机构');
            $table->longText('financing_history')->default('')->comment('融资历史');
            $table->longText('core_team')->default('')->comment('核心团队');
            $table->longText('enterprise_business')->default('')->comment('企业业务');
            $table->longText('legal_proceedings')->default('')->comment('法律诉讼');
            $table->longText('court_notice')->default('')->comment('法院公告');
            $table->longText('dishonest_person')->default('')->comment('失信人');
            $table->longText('person_subjected_execution')->default('')->comment('被执行人');
            $table->longText('abnormal_operation')->default('')->comment('经营异常');
            $table->longText('administrative_sanction')->default('')->comment('行政处罚');
            $table->longText('serious_violation')->default('')->comment('严重违规');
            $table->longText('stock_ownership')->default('')->comment('股权出质');
            $table->longText('chattel_mortgage')->default('')->comment('动产抵押');
            $table->longText('tax_notice')->default('')->comment('欠税公告');
            $table->longText('bidding')->default('')->comment('招投标');
            $table->longText('purchase_information')->default('')->comment('购地信息');
            $table->longText('tax_rating')->default('')->comment('税务评级');
            $table->longText('qualification_certificate')->default('')->comment('资质证书');
            $table->longText('trademark_information')->default('')->comment('商标信息');
            $table->longText('patent')->default('')->comment('专利');
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
        Schema::drop('provider_business');
    }
}
