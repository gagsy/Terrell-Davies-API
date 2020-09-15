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
    {   Schema::disableForeignKeyConstraints();
        Schema::create('properties', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('prperty_cat_id')->constrained('property_categories')->onDelete('cascade');
            $table->foreignId('prperty_type_id')->constrained('property_types')->onDelete('cascade');
            $table->string('title');
            $table->longText('description');
            $table->string('state');
            $table->string('market_status');
            $table->string('locality');
            $table->float('budget', 8, 2);
            $table->string('featuredImage');
            $table->string('galleryImage');
            $table->string('agent');
            $table->string('features');
            $table->string('bedroom');
            $table->string('bathroom');
            $table->string('garage');
            $table->string('toilet');
            $table->string('totalarea');
            $table->string('video_link')->nullable();
            $table->integer('views')->nullable();
            $table->longText('metaDescription');
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
