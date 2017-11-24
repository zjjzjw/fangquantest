<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableContentAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('content', function ($table) {
            $table->string('url', 255)->default('')->comment('跳转URL')->after('author');
            $table->integer('audio')->default(0)->comment('视频')->after('url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('content', function ($table) {
            $table->dropColumn('url');
            $table->dropColumn('audio');
        });
    }
}
