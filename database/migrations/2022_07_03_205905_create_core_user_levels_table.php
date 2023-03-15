<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoreUserLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('core_user_levels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('accesslevel_code')->nullable();
            $table->string('accesslevel');
            $table->string('allow_module')->nullable();
            $table->string('allow_submodule')->nullable();
            $table->string('allow_subsub_module')->nullable();
            $table->string('add')->nullable();
            $table->string('edit')->nullable();
            $table->string('delete')->nullable();
            $table->string('export')->nullable();
            $table->string('import')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('core_user_levels');
    }
}
