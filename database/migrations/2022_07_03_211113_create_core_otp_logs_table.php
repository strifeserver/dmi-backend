<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoreOtpLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('core_otp_logs', function (Blueprint $table) {
            $table->id();
            $table->string('otp')->nullable();
            $table->text('token')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('expiration_at')->nullable();
            $table->integer('status')->default('0')->nullable();
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
        Schema::dropIfExists('core_otp_logs');
    }
}
