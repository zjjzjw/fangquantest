<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProviderDomesticImportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_domestic_import', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('provider_id')->default(0)->comment('供应商id');
            $table->integer('domestic_import_id')->default(0)->comment('进口国产');
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
        Schema::drop('provider_domestic_import');
    }
}
