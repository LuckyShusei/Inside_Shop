<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->integer('project_type')->default(0);
            $table->integer('client')->nullable();
            $table->integer('manager')->nullable();
            $table->integer('status')->default(0);
            $table->text('detail')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('image', 50)->nullable();
            $table->integer('organization_id')->unsigned()->default(0);
            $table->integer('sort_order')->default(0);
            $table->boolean('active_flag')->default(1);
            $table->timestamps();
            $table->softDeletes();
            $table->integer('created_user_id')->unsigned()->default(null)->nullable();
            $table->integer('updated_user_id')->unsigned()->default(null)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
