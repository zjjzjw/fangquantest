<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaManagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_management', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->default('')->comment('媒体名称');
            $table->bigInteger('type')->default(0)->comment('媒体类型');
            $table->bigInteger('logo')->default(0)->comment('媒体logo');
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
        Schema::dropIfExists('media_management');
    }
}
