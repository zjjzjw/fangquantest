<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeveloperProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('developer_project', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 50)->default('')->comment('项目名称');
            $table->timestamp('time')->default('0000-00-00 00:00:00')->comment('发布时间');
            $table->bigInteger('developer_id')->default(0)->comment('开发商id');
            $table->integer('project_stage_id')->default(0)->comment('项目阶段id');
            $table->tinyInteger('is_great')->default(0)->comment('是否优选 1=是 2=否');
            $table->tinyInteger('developer_type')->default(0)->comment('开发商类型 1=百强开发商; 2=普通开发商');
            $table->integer('province_id')->default(0)->comment('省份id');
            $table->integer('city_id')->default(0)->comment('城市id');
            $table->string('address', 255)->default('')->comment('详细地址');
            $table->integer('cost')->default(0)->comment('造价 万元');
            $table->integer('views')->default(0)->comment('浏览数');
            $table->tinyInteger('type')->default(0)->comment('项目类型 1=新建 2=翻新 3=扩建 4=室内装饰 5=设备安装');
            $table->tinyInteger('project_category')->default(0)->comment('项目类别 1-住宅、2-酒店、3-工业、4-办公楼、5-商业综合体、6其它');
            $table->timestamp('time_start')->default('0000-00-00 00:00:00')->comment('项目开始时间');
            $table->timestamp('time_end')->default('0000-00-00 00:00:00')->comment('项目结束时间');
            $table->tinyInteger('stage_design')->default(0)->comment('设计阶段 1=未开始 2=进行中 3=结束 4= 未知');
            $table->tinyInteger('stage_build')->default(0)->comment('施工阶段 1=未开始 2=进行中 3=结束 4= 未知');
            $table->tinyInteger('stage_decorate')->default(0)->comment('装修阶段 1=未开始 2=进行中 3=结束 4= 未知');
            $table->integer('floor_space')->default(0)->comment('建筑面积 平米');
            $table->integer('floor_numbers')->default(0)->comment('建筑层数');
            $table->integer('investments')->default(0)->comment('总投资额 万元');
            $table->string('heating_mode', 50)->default('')->comment('供暖方式');
            $table->string('wall_materials', 50)->default('')->comment('外墙材料');
            $table->tinyInteger('has_decorate')->default(0)->comment('是否精装修 1=是 2=否 3=未知');
            $table->tinyInteger('has_airconditioner')->default(0)->comment('有无空调 1=是 2=否 3=未知');
            $table->tinyInteger('has_steel')->default(0)->comment('有无钢结构 1=是 2=否 3=未知');
            $table->tinyInteger('has_elevator')->default(0)->comment('有无电梯 1=是 2=否 3=未知');
            $table->text('summary')->default('')->comment('项目概括');
            $table->tinyInteger('status')->default(0)->comment('状态 1=正常上架状态 2=下架');
            $table->tinyInteger('source')->default(0)->comment('数据来源 1=RCC瑞达恒 2=天辰 3=中国招标与采购网 4=中国拟在建项目网 5=千里马-优质 6=千里马-普通 7=东方雨虹 8=明源云采购网  9=私有');
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
        Schema::dropIfExists('developer_project');
    }
}
