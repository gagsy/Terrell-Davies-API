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
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('category_id')->index();
            $table->unsignedBigInteger('type_id')->index();
            $table->unsignedBigInteger('location_id')->index()->nullable();
            $table->string('title');
            $table->string('location');
            $table->longText('description');
            $table->string('state');
            $table->string('area');
            $table->string('total_area');
            $table->string('market_status');
            $table->string('parking');
            $table->string('locality');
            $table->double('budget', 10, 2);
            $table->string('image');
            $table->string('bedroom');
            $table->string('bathroom');
            $table->string('toilet');
            $table->string('ref_no');
            $table->string('video_link')->nullable();
            $table->enum('status',['Publish','Unpublish']);
            $table->enum('feature',['Serviced','Furnished']);
            $table->integer('views')->nullable();
            $table->tinyInteger('visible')->default(1);
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('user_id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');
            $table->foreign('location_id')
            ->references('id')
            ->on('locations')
            ->onDelete('cascade');
            $table->foreign('type_id')->references('id')->on('types')->onDelete('cascade');
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
    }
}
