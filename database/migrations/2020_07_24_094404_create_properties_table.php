<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('description');
            $table->longText('location');
            $table->string('type');
            $table->string('status');
            $table->string('price');
            $table->string('featuredImage');
            $table->string('galleryImage');
            $table->unsignedBigInteger('user_id')->index();
            $table->string('agent');
            $table->string('feature');
            $table->string('bedroom');
            $table->string('bathroom');
            $table->string('garage');
            $table->string('toilet');
            $table->integer('views');
            $table->longText('metaDescription');
            $table->tinyInteger('visible');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('properties');
        //$table->dropColumn('slug');
    }
}
