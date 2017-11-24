<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeveloperProjectCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('developer_project_category', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('developer_project_id')->default(0)->comment('开发商项目id');
            $table->integer('product_category_id')->default(0)->comment('产品分类表id');
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
        Schema::dropIfExists('developer_project_category');
    }
}
