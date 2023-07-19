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
        Schema::create('species_infos', function (Blueprint $table) {
            $table->mediumInteger('intensity_count');
            $table->string('infotype', 20);
            $table->foreignId('species_id');
            $table->foreignId('location_id');
            $table->foreignId('infotype_id');
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
        Schema::dropIfExists('species_infos');
    }
};
