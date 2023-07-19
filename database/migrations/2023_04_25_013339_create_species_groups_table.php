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
        Schema::create('species_groups', function (Blueprint $table) {
            $table->id('group_id');
            $table->foreignId('species_id')->nullable();
            $table->foreignId('plantation_id')->nullable();
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
        Schema::dropIfExists('species_groups');
    }
};
