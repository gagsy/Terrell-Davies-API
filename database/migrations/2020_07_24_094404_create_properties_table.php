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
            $table->unsignedBigInteger('prperty_cat_id')->index();
            $table->unsignedBigInteger('prperty_type_id')->index();
            $table->string('title');
            $table->longText('description');
            $table->string('state');
            $table->string('market_status');
            $table->string('locality');
            $table->decimal('budget',5, 2);
            $table->string('featuredImage');
            $table->string('galleryImage');
            $table->string('agent');
            $table->string('feature');
            $table->string('bedroom');
            $table->string('bathroom');
            $table->string('garage');
            $table->string('toilet');
            $table->string('totalarea');
            $table->string('video_link')->nullable();
            $table->integer('views')->nullable();
            $table->longText('metaDescription');
            $table->tinyInteger('visible')->default(1);
            $table->foreign('prperty_cat_id')->references('id')->on('property_categories')->onDelete('cascade');
            $table->foreign('prperty_type_id')->references('id')->on('property_types')->onDelete('cascade');
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
