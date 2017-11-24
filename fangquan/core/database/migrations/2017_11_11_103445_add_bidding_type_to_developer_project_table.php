<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBiddingTypeToDeveloperProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('developer_project', function (Blueprint $table) {
            $table->tinyInteger('bidding_type')->after('contacts_email')->default(0)->comment('招标类型 1项目招标 2战略集采');
            $table->string('deadline_for_registration', 50)->after('bidding_type')->default('')->comment('报名截止时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('developer_project', function (Blueprint $table) {
            $table->dropColumn('bidding_type');
            $table->dropColumn('deadline_for_registration');
        });
    }
}
