<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoreNavigationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('core_navigations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nav_name')->nullable();
            $table->string('nav_table')->nullable();
            $table->string('nav_mode')->nullable();
            $table->string('nav_controller')->nullable();
            $table->string('nav_icon')->nullable();
            $table->string('system_nav')->nullable();
            $table->string('nav_group')->nullable();
            $table->string('nav_type')->nullable();
            $table->Integer('nav_order')->nullable();
            $table->Integer('nav_suborder')->nullable();
            $table->Integer('nav_parent_id')->nullable();
            $table->Integer('nav_sub_get_parent')->nullable();
            $table->string('nav_status')->default('1');
            $table->smallInteger('add')->nullable();
            $table->smallInteger('edit')->nullable();
            $table->smallInteger('delete')->nullable();
            $table->smallInteger('export')->nullable();
            $table->smallInteger('import')->nullable();
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
        Schema::dropIfExists('core_navigations');
    }
}
