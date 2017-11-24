<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCompanyTypeToProviderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('provider', function (Blueprint $table) {
            $table->integer('company_type')->after('brand_name')->default(0)->comment('公司类型');
            $table->string('corp_phone', 50)->after('corp')->default('')->comment('企业法人联系方式');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('provider', function (Blueprint $table) {
            $table->dropColumn('company_type');
            $table->dropColumn('corp_phone');
        });
    }
}
