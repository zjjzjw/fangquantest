<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThirdPartyBindTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('third_party_bind', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('third_type')->default(0)->comment('来源: 1=微信 2=微博 3=qq');
            $table->string('open_id', 64)->default('')->comment('第三方登录返回的openid');
            $table->bigInteger('user_id')->default(0)->comment('用户ID');
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
        Schema::table('third_party_bind', function (Blueprint $table) {
            //
        });
    }
}
