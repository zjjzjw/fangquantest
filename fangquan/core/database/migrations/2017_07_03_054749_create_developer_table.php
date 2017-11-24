<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeveloperTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('developer', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 50)->default('')->comment('开发商名称');
            $table->integer('logo')->default(0)->comment('logo地址');
            $table->integer('status')->default(0)->comment('开发商状态 1=已认证 2=未认证 3=下架');
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
        Schema::dropIfExists('developer');
    }
}
