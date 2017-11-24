<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProviderNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_news', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('provider_id')->default(0)->comment('供应商ID');
            $table->string('title', 128)->default('')->comment('标题');
            $table->text('content')->default('')->comment('内容');
            $table->tinyInteger('status')->default(0)->comment('状态 1=待审核 2=审核通过 3=审核驳回');
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
        Schema::dropIfExists('provider_news');
    }
}
