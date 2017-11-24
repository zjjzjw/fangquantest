<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResourceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('resource', function (Blueprint $table) {
            $table->increments('id');
            $table->string('bucket', 255)->default('')->comment('图片bucket');
            $table->string('hash', 255)->default('')->comment('图片hash');
            $table->string('processed_hash', 28)->default('');
            $table->string('mime_type', 255)->default('')->comment('mime_tye值');
            $table->text('desc')->default('')->comment('图片描述');
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
        Schema::drop('resource');
    }
}
