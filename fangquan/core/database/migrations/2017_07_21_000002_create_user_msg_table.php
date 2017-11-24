<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserMsgTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_msg', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('msg_id')->default(0)->comment('消息ID');
            $table->integer('from_uid')->default(0)->comment('发送者');
            $table->integer('to_uid')->default(0)->comment('接受者');
            $table->tinyInteger('msg_type')->default(0)->comment('消息类型 1 系统消息');
            $table->timestamp('read_at')->default('0000-00-00 00:00:00')->comment('阅读时间');
            $table->tinyInteger('status')->default(0)->comment('阅读时间 1 已读 2未读');
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
        Schema::drop('user_msg');
    }
}
