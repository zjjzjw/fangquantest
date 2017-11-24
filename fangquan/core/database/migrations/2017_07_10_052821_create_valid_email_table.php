<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateValidEmailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('valid_email', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email', 64)->default('')->comment('对应用户表的email');
            $table->string('verifycode', 6)->default('')->comment('验证码');
            $table->bigInteger('user_id')->default(0)->comment('用户ID');
            $table->tinyInteger('type')->default(0)->comment('类别: 1=注册 2=修改邮箱 3=修改密码');
            $table->timestamp('expire')->default('0000-00-00 00:00:00')->comment('过期时间');
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
        Schema::dropIfExists('valid_email');
    }
}
