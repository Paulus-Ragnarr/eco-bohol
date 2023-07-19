<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id('image_id');
            $table->string('image')->nullable();
            // options for imageFor:
            // project_img
            // species_img
            // propagule_img
            // flower_img
            // leaves_img
            $table->string('imageFor', 20)->default('project_img');
            $table->string('imageFilename');
            $table->foreignId('project_id')->nullable();
            $table->foreignId('species_record_id')->nullable();
            $table->foreignId('resjournal_id')->nullable();
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
        Schema::dropIfExists('images');
    }
};
