<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('account')->default('')->comment('账号');
            $table->string('company_id')->default(0)->comment('公司ID');
            $table->string('company_name')->default('')->comment('公司名称');
            $table->string('employee_id', 50)->default('')->comment('工号ID');
            $table->string('position', 100)->default('')->comment('职位');
            $table->string('name')->default('')->comment('姓名');
            $table->string('email')->default('')->comment('邮箱');
            $table->string('phone', 50)->default('')->comment('手机号');
            $table->string('password')->default('')->comment('密码');
            $table->integer('status')->default(0)->comment('状态');
            $table->integer('type')->default(0)->comment('用户类型');
            $table->integer('created_user_id')->default(0)->comment('创建者ID');
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
        Schema::drop('user');
    }
}
