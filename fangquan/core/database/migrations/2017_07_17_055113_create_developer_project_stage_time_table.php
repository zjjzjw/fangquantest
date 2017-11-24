<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeveloperProjectStageTimeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('developer_project_stage_time', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('project_id')->default(0)->comment('项目id');
            $table->integer('stage_type')->default(0)->comment('阶段类型');
            $table->timestamp('time')->default('0000-00-00 00:00:00')->comment('阶段时间');
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
        Schema::dropIfExists('developer_project_stage_time');
    }
}
