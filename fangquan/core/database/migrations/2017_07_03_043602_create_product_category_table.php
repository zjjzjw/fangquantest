<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_category', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50)->default('')->comment('名称');
            $table->integer('parent_id')->default(0)->comment('父ID');
            $table->tinyInteger('status')->default(0)->comment('状态');
            $table->tinyInteger('sort')->default(0)->comment('排序');
            $table->string('description', 255)->default('')->comment('描述');
            $table->text('attribfield')->default('')->comment('字段');
            $table->tinyInteger('is_leaf')->default(0)->comment('是否叶子节点');
            $table->tinyInteger('level')->default(0)->comment('深度');
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
        Schema::dropIfExists('product_category');
    }

}
