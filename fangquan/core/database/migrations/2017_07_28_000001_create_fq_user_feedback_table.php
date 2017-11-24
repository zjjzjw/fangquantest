<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFqUserFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fq_user_feedback', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fq_user_id')->default(0)->comment('用户标识');
            $table->integer('image_id')->default(0)->comment('图片ID');
            $table->string('contact', 50)->default('')->comment('联系方式');
            $table->string('device', 50)->default('')->comment('来源名称');
            $table->string('appver', 50)->default('')->comment('app版本');
            $table->string('content', 255)->default('')->comment('反馈内容');
            $table->tinyInteger('status')->default(0)->comment('状态');
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
        Schema::dropIfExists('fq_user_feedback');
    }
}
