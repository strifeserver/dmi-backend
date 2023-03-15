<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoreControllers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('core_controllers', function (Blueprint $table) {
            $table->id();
            $table->string('url')->nullable();
            $table->string('controller_name')->nullable();
            $table->string('function_name')->nullable();
            $table->string('route_type')->nullable();
            $table->string('model_create')->nullable();
            $table->string('model_name')->nullable();
            $table->string('blade_create')->nullable();
            $table->string('blade_name')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('core_controllers');
    }
}
