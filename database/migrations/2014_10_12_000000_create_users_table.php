<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone');
            $table->string('userType')->default('individual');
            $table->string('company_name')->nullable();
            $table->string('address')->nullable();
            $table->string('locality')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('mobile')->nullable();
            $table->string('services')->nullable();
            $table->string('facebook_profile')->nullable();
            $table->string('twitter_profile')->nullable();
            $table->string('linkedin_profile')->nullable();
            $table->string('isActivated')->default('Active');
            $table->string('passwordResetCode')->nullable();
            $table->string('activationCode')->nullable();
            $table->string('socialType')->nullable();
            $table->string('avatar')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
