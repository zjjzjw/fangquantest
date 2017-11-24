<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandSupplementaryFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brand_supplementary_file', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('file_id')->default(0)->comment('文件id');
            $table->integer('brand_supplementary_id')->default(0)->comment('材料id');
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
        Schema::drop('brand_supplementary_file');
    }
}
