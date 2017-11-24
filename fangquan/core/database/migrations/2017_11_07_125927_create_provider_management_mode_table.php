<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProviderManagementModeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_management_mode', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('provider_id')->default(0)->comment('供应商id');
            $table->integer('management_mode_type')->default(0)->comment('工程经营模式');
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
        Schema::dropIfExists('provider_management_mode');
    }
}
