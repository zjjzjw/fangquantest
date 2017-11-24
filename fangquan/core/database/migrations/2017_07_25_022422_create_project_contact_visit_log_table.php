<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectContactVisitLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_contact_visit_log', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->default(0)->comment('用户标识');
            $table->bigInteger('developer_project_id')->default(0)->comment('开发商项目标识');
            $table->tinyInteger('role_type')->default(0)->comment('角色类型: 1=未知(自注册) 2=供应商 3=开发商开发商');
            $table->bigInteger('role_id')->default(0)->comment('角色ID role_type=2 => provider_id； role_type=3 => developer_id');
            $table->index(['user_id', 'developer_project_id']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_contact_visit_log');
    }
}
