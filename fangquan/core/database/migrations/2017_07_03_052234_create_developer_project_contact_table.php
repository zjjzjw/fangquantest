<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeveloperProjectContactTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('developer_project_contact', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('developer_project_id')->default(0)->comment('开发商项目id');
            $table->integer('type')->default(0)->comment('类型 1=开发商 2=建筑单位 3=设计院 4=其他');
            $table->integer('sort')->default(0)->comment('排序');
            $table->string('company_name', 50)->default('')->comment('公司名称');
            $table->string('contact_name', 50)->default('')->comment('联系人姓名');
            $table->string('job', 50)->default('')->comment('联系人职务');
            $table->string('address', 255)->default('')->comment('地址');
            $table->string('telphone', 50)->default('')->comment('联系方式');
            $table->string('mobile', 50)->default('')->comment('手机号码');
            $table->string('remark', 255)->default('')->comment('备注');
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
        Schema::dropIfExists('developer_project_contact');
    }
}
