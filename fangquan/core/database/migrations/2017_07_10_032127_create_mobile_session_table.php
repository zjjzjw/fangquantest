<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMobileSessionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mobile_session', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->default(0)->comment('用户ID');
            $table->string('token', 64)->default('')->comment('用户访问令牌');
            $table->string('reg_id', 128)->default('')->comment('推送设备ID');
            $table->tinyInteger('type')->default(0)->comment('设备类型: 1=安卓 2=ios');
            $table->tinyInteger('enable_notify')->default(0)->comment('是否开启推送通知: 1=关闭 2=开启');
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
        Schema::dropIfExists('mobile_session');
    }
}
