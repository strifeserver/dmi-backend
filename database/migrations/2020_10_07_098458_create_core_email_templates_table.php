<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoreEmailTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('core_email_templates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('identifier');
            $table->string('name');
            $table->string('title');
            $table->string('email');
            $table->string('subject');
            $table->longtext('content');
            $table->longtext('auto_reply');
            $table->string('succes_message')->default("Thank you for emailing us!");
            $table->integer('is_enabled')->default(0);
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
        Schema::dropIfExists('core_email_templates');
    }
}
