<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduleLists extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_lists', function (Blueprint $table) {
            $table->id();
            $table->string('survey_tracking_id')->nullable();
            $table->integer('survey_id')->nullable();
            $table->string('schedule_title')->nullable();
            $table->text('requested_by')->nullable();
            $table->text('approved_by')->nullable();
            $table->dateTime('schedule_raw')->nullable();
            $table->string('date')->nullable();
            $table->string('end_date')->nullable();
            $table->string('time')->nullable();
            $table->string('schedule_type')->default('appointment');
            $table->string('classes')->default('chip-blue');
            $table->text('description')->nullable();
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('schedule_lists');
    }
}
