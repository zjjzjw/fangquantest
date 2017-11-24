<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandFriendTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brand_friend', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('brand_id')->default(0)->comment('品牌id');
            $table->integer('brand_friend_id')->default(0)->comment('合作商id');
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
        Schema::drop('brand_friend');
    }
}
