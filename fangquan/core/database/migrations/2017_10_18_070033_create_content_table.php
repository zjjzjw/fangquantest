<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 100)->default('')->comment('标题');
            $table->string('author', 50)->default('')->comment('作者');
            $table->text('content')->default('')->comment('内容');
            $table->string('remake', 255)->default('')->comment('备注');
            $table->integer('type')->default(0)->comment('类型');
            $table->integer('is_timing_publish')->default(0)->comment('是否定时发布1=是 2=否');
            $table->dateTime('publish_time')->default('0000-00-00 00:00:00')->comment('是否定时发布1=是 2=否');
            $table->tinyInteger('status')->default('0')->comment('状态 1=是 2=否');
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
        Schema::drop('content');
    }
}
