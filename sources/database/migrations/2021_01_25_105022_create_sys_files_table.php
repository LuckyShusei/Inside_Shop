<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_files', function (Blueprint $table) {
            $table->string('id', 50);
            $table->string('name', 50);
            $table->string('client_name', 80);
            $table->string('extension', 10);
            $table->string('mime_type', 100);
            $table->integer('size');
            $table->string('link_uri', 255);
            $table->string('thumbnail_uri', 255)->nullable();
            $table->timestamp('expired_at', 0)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->integer('created_user_id')->unsigned()->default(null)->nullable();
            $table->integer('updated_user_id')->unsigned()->default(null)->nullable();
            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_files');
    }
}
