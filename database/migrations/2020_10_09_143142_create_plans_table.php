<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->double('price', 10 ,2);
            $table->string('duration');
            $table->string('discount_month1')->nullable(); 
            $table->string('discount_month2')->nullable();
            $table->string('maximum_listings')->nullable();
            $table->string('maximum_premium_listings')->nullable();
            $table->string('max_featured_ad_listings')->nullable();
            $table->string('gateway_id')->nullable();
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
        Schema::dropIfExists('plans');
    }
}
