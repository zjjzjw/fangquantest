<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBroadcastMsgTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('broadcast_msg', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('from_uid')->default(0)->comment('发送者');
            $table->bigInteger('msg_id')->default(0)->comment('消息ID');
            $table->tinyInteger('msg_type')->default(0)->comment('消息类型');
            $table->tinyInteger('status')->default(0)->comment('广播消息状态');
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
        Schema::drop('broadcast_msg');
    }
}
