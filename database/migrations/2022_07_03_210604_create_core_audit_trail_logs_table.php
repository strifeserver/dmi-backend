<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoreAuditTrailLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('core_audit_trail_logs', function (Blueprint $table) {
            $table->id();
            $table->string('module')->nullable();
            $table->string('category')->nullable();
            $table->string('username')->nullable();
            $table->text('action_taken')->nullable();
            $table->text('remarks')->nullable();
            $table->text('ip')->nullable();
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
        Schema::dropIfExists('core_audit_trail_logs');
    }
}
