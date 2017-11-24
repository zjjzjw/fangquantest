<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBrandTotalAmountToBrandSignListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('brand_sign_list', function (Blueprint $table) {
            $table->decimal('brand_total_amount', 11 ,2)->default(0)->after('status')->comment('项目总金额');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('brand_sign_list', function (Blueprint $table) {
            $table->dropColumn('brand_total_amount');
        });
    }
}
