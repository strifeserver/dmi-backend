<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailOutboxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_outboxes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('send_to')->nullable();
            $table->text('cc_to')->nullable();
            $table->string('template_id')->nullable();
            $table->string('subject')->nullable();
            $table->text('content')->nullable();
            $table->text('raw_content')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('email_outboxes');
    }
}
