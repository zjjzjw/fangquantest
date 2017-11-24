<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDeveloperNameToBrandSignDeveloper extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('brand_sign_developer', function (Blueprint $table) {
            $table->string('developer_name', 50)->after('developer_id')->default('')->comment('开发商名称');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('brand_sign_developer', function (Blueprint $table) {
            $table->dropColumn('developer_name');
        });
    }
}
