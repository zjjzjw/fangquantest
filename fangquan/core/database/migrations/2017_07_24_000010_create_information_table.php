<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('information', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->default('')->comment('标题');
            $table->string('author')->default('')->comment('作者');
            $table->integer('thumbnail')->default(0)->comment('缩略图ID');
            $table->timestamp('publish_at')->default('0000-00-00 00:00:00')->comment('发布时间');
            $table->integer('product_id')->default(0)->comment('产品ID');
            $table->integer('tag_id')->default(0)->comment('文章标签');
            $table->text('content')->default('')->comment('内容');
            $table->integer('order')->default(0)->comment('排序');
            $table->integer('comment_count')->default(0)->comment('评论数');
            $table->tinyInteger('status')->default(0)->comment('状态');
            $table->integer('created_user_id')->default(0)->comment('创建者ID');
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
        Schema::drop('information');
    }
}
