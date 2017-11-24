<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateValidMobileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('valid_mobile', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('mobile', 11)->default(0)->comment('用户ID');
            $table->string('verifycode', 6)->default('')->comment('验证码');
            $table->timestamp('expire')->default('0000-00-00 00:00:00')->comment('过期时间');
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
        Schema::dropIfExists('valid_mobile');
    }
}
