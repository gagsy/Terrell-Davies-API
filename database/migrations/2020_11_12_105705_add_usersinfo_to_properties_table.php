<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUsersinfoToPropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->string('user_name')->nullable();
            $table->string('user_email')->nullable();
            $table->string('user_phone')->nullable();
            $table->string('user_type')->nullable();
            $table->string('user_company_name')->nullable();
            $table->string('user_company_description')->nullable();
            $table->string('user_company_phone')->nullable();
            $table->string('user_company_logo')->nullable();
            $table->string('user_address')->nullable();
            $table->string('user_locality')->nullable();
            $table->string('user_state')->nullable();
            $table->string('user_country')->nullable();
            $table->string('user_services')->nullable();
            $table->string('user_facebook_profile')->nullable();
            $table->string('user_twitter_profile')->nullable();
            $table->string('user_linkedin_profile')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn('user_name');
            $table->dropColumn('user_email');
            $table->dropColumn('user_phone');
            $table->dropColumn('user_type');
            $table->dropColumn('user_company_name');
            $table->dropColumn('user_company_phone');
            $table->dropColumn('user_company_logo');
            $table->dropColumn('user_address');
            $table->dropColumn('user_locality');
            $table->dropColumn('user_state');
            $table->dropColumn('user_country');
            $table->dropColumn('user_services');
            $table->dropColumn('user_facebook_profile');
            $table->dropColumn('user_twitter_profile');
            $table->dropColumn('user_linkedin_profile');
        });
    }
}
