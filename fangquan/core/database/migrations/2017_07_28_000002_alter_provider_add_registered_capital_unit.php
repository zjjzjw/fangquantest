<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterProviderAddRegisteredCapitalUnit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('provider', function ($table) {
            $table->string('registered_capital_unit', 50)->default('')->comment('关闭原因')->after('registered_capital');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('provider', function ($table) {
            $table->dropColumn('registered_capital_unit');
        });
    }
}
