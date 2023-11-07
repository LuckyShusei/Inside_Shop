<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesPrivilegesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles_privileges', function (Blueprint $table) {
            $table->integer('role_id')->unsigned();
            $table->string('privilege', 50);
            $table->boolean('active_flag')->default(1);
            $table->timestamps();
            $table->softDeletes();
            $table->integer('created_user_id')->default(0);
            $table->integer('updated_user_id')->default(0);
            $table->primary(['role_id', 'privilege']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles_privileges');
    }
}
