<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 50)->index();
            $table->string('information_mail_from', 255)->nullable();
            $table->string('information_mail_to', 255)->nullable();
            $table->string('logo_image', 50)->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('active_flag')->default(1);
            $table->timestamps();
            $table->softDeletes();
            $table->integer('created_user_id')->default(0);
            $table->integer('updated_user_id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organizations');
    }
}
