<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->integer('project_id')->default(0);
            $table->integer('item_type')->default(0);
            $table->integer('manager')->nullable();
            $table->integer('status')->default(0);
            $table->text('detail')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
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
        Schema::dropIfExists('items');
    }
}
