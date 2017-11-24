<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVotesToBrandFactoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('brand_factory', function (Blueprint $table) {

            $table->decimal('production_area', 11, 2)->default(0)->comment('生产面积')->change();
            $table->string('unit')->default('')->after('production_area')->comment('面积单位');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('brand_factory', function (Blueprint $table) {
            $table->string('production_area', 50)->default('')->comment('生产面积')->change();
            $table->dropColumn('unit');
        });
    }
}
