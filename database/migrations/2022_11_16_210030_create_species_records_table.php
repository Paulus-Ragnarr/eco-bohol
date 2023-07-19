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
        Schema::create('species_records', function (Blueprint $table) {
            $table->id('species_id');
            $table->binary('species_img')->nullable();
            $table->string('scientific_name', 50);
            $table->string('common_name', 50);
            $table->string('kingdom', 30);
            $table->string('phylum', 30);
            $table->string('class', 30);
            $table->string('order', 30);
            $table->string('family', 30);
            $table->string('genus', 30);
            $table->string('species_descrp', 500);
            $table->binary('propagule_img')->nullable();
            $table->string('propagule_descrp', 500)->nullable();
            $table->binary('flower_img')->nullable();
            $table->string('flower_descrp', 500)->nullable();
            $table->string('style', 500)->nullable();
            $table->binary('leaves_img')->nullable();
            $table->string('leaves_descrp', 500)->nullable();
            $table->string('zonation', 500)->nullable();
            $table->string('relev_com', 500)->nullable();
            $table->string('conserv_status', 50);
            $table->string('status', 10)->default('active');
            $table->foreignId('user_id');
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
        Schema::dropIfExists('species_records');
    }
};
