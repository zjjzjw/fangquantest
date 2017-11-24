<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandSignListCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brand_sign_list_category', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('project_sign_id')->default(0)->comment('订单签订清单id');
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
        Schema::drop('brand_sign_list_category');
    }
}
