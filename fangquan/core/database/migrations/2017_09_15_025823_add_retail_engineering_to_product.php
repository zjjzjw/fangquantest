<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRetailEngineeringToProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product', function (Blueprint $table) {
            $table->decimal('engineering_price', 10, 2)->default(0)->after('price')->comment('工程指导价');
            $table->decimal('retail_price', 10 ,2)->default(0)->after('price')->comment('零售指导价');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product', function (Blueprint $table) {
            $table->dropColumn('engineering_price');
            $table->dropColumn('retail_price');
        });
    }
}
