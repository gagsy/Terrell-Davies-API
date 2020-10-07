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
            $table->string('category');
            $table->string('type');
            $table->string('location');
            $table->string('title');
            $table->longText('description');
            $table->string('state');
            $table->string('area');
            $table->string('total_area');
            $table->string('market_status');
            $table->string('parking');
            $table->string('locality');
            $table->float('budget', 8, 2);
            $table->string('featuredImage');
            $table->string('galleryImage');
            $table->string('bedroom');
            $table->string('bathroom');
            $table->string('toilet');
            $table->string('video_link')->nullable();
            $table->enum('status',['Publish','Unpublish']);
            $table->enum('feature',['Serviced','Furnished']);
            $table->integer('views')->nullable();
            $table->tinyInteger('visible')->default(1);
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
