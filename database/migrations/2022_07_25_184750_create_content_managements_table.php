<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentManagementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_managements', function (Blueprint $table) {
            $table->id();
            $table->string('content_thumbnail')->default('placeholder.webp');
            $table->string('content_title')->default('No Title');
            $table->string('content_schedule')->nullable();
            $table->string('content_time')->nullable();
            $table->string('content_start_time')->nullable();
            $table->string('content_end_time')->nullable();
            $table->string('content_location')->nullable();
            $table->text('content_url')->nullable();
            $table->text('content_images')->nullable();
            $table->text('content_description')->nullable();
            $table->string('content_category')->nullable()->default('default');
            $table->string('content_tags')->nullable();
            $table->string('content_files')->nullable();
            $table->integer('content_status')->default(1);
            $table->integer('is_live')->default(0);
            $table->integer('created_by')->nullable()->default(0);
            $table->integer('updated_by')->nullable()->default(0);
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
        Schema::dropIfExists('content_managements');
    }
}
