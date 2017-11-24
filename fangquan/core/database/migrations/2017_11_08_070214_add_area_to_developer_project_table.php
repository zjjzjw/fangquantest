<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAreaToDeveloperProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('developer_project', function (Blueprint $table) {
            $table->string('other', 255)->after('source')->default('')->comment('其他信息');
            $table->string('area', 100)->after('source')->default('')->comment('区域');
            $table->string('contacts', 50)->after('source')->default('')->comment('联系人');
            $table->string('contacts_phone', 50)->after('contacts')->default('')->comment('联系人电话');
            $table->string('contacts_address', 100)->after('contacts_phone')->default('')->comment('联系地址');
            $table->string('contacts_email', 50)->after('contacts_address')->default('')->comment('联系邮箱');
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
            $table->dropColumn('other');
            $table->dropColumn('area');
            $table->dropColumn('contacts');
            $table->dropColumn('contacts_phone');
            $table->dropColumn('contacts_address');
            $table->dropColumn('contacts_email');
        });
    }
}
