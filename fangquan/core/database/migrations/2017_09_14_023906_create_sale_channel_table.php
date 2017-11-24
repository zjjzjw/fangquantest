<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaleChannelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_channel', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('sale_year')->default(0)->comment('年份');
            $table->integer('brand_id')->default(0)->comment('品牌标示');
            $table->integer('channel_type')->default(0)->comment('渠道类型');
            $table->decimal('sale_volume', 11, 2)->default(0)->comment('销售量');
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
        Schema::dropIfExists('sale_channel');
    }
}
