<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuditTrailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_trails', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('log_id')->nullable();
            $table->string('module')->nullable();
            $table->string('action_taken')->nullable();
            $table->text('before_changes')->nullable();
            $table->text('after_changes')->nullable();
            $table->text('changes')->nullable();
            $table->text('details')->nullable();
            $table->text('remarks')->nullable();
            $table->text('user_hash')->nullable();
            $table->text('created_by')->nullable();
            $table->text('updated_by')->nullable();
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
        Schema::dropIfExists('audit_trails');
    }
}
