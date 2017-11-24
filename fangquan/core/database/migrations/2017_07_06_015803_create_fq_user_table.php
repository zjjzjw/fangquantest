<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 用户表
 * Class CreateUserTable
 */
class CreateFqUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fq_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nickname', 32)->default('')->comment('昵称');
            $table->string('mobile', 11)->default('')->comment('手机号码');
            $table->string('email', 64)->default('')->comment('邮箱');
            $table->string('account', 32)->default('')->comment('用户账号:后台创建');
            $table->tinyInteger('account_type')->default(0)->comment('账号类型: 1=免费账号 2=试用账号 3=正式账号');
            $table->tinyInteger('role_type')->default(0)->comment('角色类型: 1=未知(自注册) 2=供应商 3=开发商');
            $table->bigInteger('role_id')->default(0)->comment('角色id role_type=2 => provider_id； role_type=3 => developer_id');
            $table->tinyInteger('platform_id')->default(0)->comment('用户来源平台表ID');
            $table->tinyInteger('register_type_id')->default(0)->comment('用户注册类型表ID');
            $table->string('salt', 32)->default('')->comment('加密盐');
            $table->string('password', 32)->default('')->comment('密码, md5(md5($password).$salt)');
            $table->bigInteger('avatar')->default(0)->comment('头像资源ID');
            $table->string('project_area', 100)->default('')->comment('账号权限:省份ID集合，以半角逗号分割开');
            $table->string('project_category', 35)->default('')->comment('账号权限:项目类别ID集合以英文逗号分割开；项目类别: 1=住宅 2=酒店 3=工业 4=办公楼 5=商业综合体 6=其它');
            $table->integer('admin_id')->default(0)->comment('admin表ID:后台创建');
            $table->timestamp('reg_time')->default('0000-00-00 00:00:00')->comment('账号注册时间');
            $table->timestamp('expire')->default('0000-00-00 00:00:00')->comment('账号过期时间');
            $table->tinyInteger('status')->default(0)->comment('用户状态: 1=正常使用 2=禁用 3=未激活');
            $table->rememberToken();
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
        Schema::dropIfExists('fq_user');
    }
}
