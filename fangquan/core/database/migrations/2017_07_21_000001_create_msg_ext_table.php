<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMsgExtTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('msg_ext', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('content')->default('')->comment('消息内容');
            $table->tinyInteger('msg_type')->default(0)->comment('系统消息');
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
        Schema::drop('msg_ext');
    }
}
