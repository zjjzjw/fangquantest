<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('parent_id')->default(0)->comment('父类id');
            $table->string('name')->default('')->comment('名称');
            $table->integer('order')->default(0)->comment('排序');
            $table->integer('status')->default(0)->comment('状态');
            $table->integer('image_id')->default(0)->comment('图标');
            $table->integer('created_user_id')->default(0)->comment('创建者');
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
        Schema::drop('category');
    }
}
