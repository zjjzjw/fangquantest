<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIconImageToProjectCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_category', function (Blueprint $table) {
            $table->string('icon_font', 50)->after('level')->default('')->comment('icon');
            $table->integer('logo')->after('level')->default(0)->comment('logo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_category', function (Blueprint $table) {
            $table->dropColumn('icon_font');
            $table->dropColumn('logo');
        });
    }
}
