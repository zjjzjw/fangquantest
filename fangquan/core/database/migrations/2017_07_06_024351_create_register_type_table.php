<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 注册类型
 * Class CreateRegisterTypeTable
 */
class CreateRegisterTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('register_type', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 32)->default('')->comment('注册类型');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('register_type');
    }
}
