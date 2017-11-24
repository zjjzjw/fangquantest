<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('city', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('province_id')->default(0)->comment('省份ID');
            $table->string('name', 50)->default('')->comment('名称');
            $table->decimal('lng', 11, 6)->default(0)->comment('经度');
            $table->decimal('lat', 11, 6)->default(0)->comment('纬度');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('city');
    }
}
