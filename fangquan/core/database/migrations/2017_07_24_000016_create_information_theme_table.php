<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateInformationThemeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('information_theme', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('information_id')->default(0)->comment('资讯ID');
            $table->integer('theme_id')->default(0)->comment('主题关键词ID');
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
        Schema::drop('information_theme');
    }
}
