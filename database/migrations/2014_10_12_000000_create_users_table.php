<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('core_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('hash')->nullable();
            $table->text('first_name')->nullable();
            $table->text('last_name')->nullable();
            $table->text('email')->nullable();
            $table->string('username');
            $table->string('console_group')->default('1');
            $table->string('sub_group')->default('1');
            $table->string('token')->nullable();
            $table->string('temporary_password')->nullable();
            $table->string('temporary_password_created')->nullable();
            $table->string('access_level')->default('1')->nullable();
            $table->string('account_status')->default('1')->nullable();
            $table->string('ip')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('password_updated_at')->nullable();
            $table->string('password');
            $table->text('google2fa_secret')->nullable();
            $table->string('otp')->nullable();
            $table->string('otp_expired_on')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('account_lock_end')->nullable();
            $table->rememberToken();
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
        // Schema::dropIfExists('users');
        Schema::dropIfExists('core_users');
        
    }
}
