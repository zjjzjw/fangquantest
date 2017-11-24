<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandCooperationCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brand_cooperation_category', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('brand_cooperation_id')->default(0)->comment('合作商id');
            $table->integer('category_id')->default(0)->comment('品类id');
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
        Schema::drop('brand_cooperation_category');
    }
}
