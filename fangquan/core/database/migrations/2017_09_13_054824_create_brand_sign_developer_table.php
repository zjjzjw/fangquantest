<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandSignDeveloperTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brand_sign_developer', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('project_sign_id')->default(0)->comment('订单签订清单id');
            $table->integer('developer_id')->default(0)->comment('开发商id');
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
        Schema::drop('brand_sign_developer');
    }
}
