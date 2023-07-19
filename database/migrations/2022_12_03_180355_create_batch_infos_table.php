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
        Schema::create('batch_infos', function (Blueprint $table) {
            $table->id('batch_id');
            $table->smallInteger('no_potted');
            $table->date('date_potted');
            $table->string('remarks', 50);
            $table->string('status', 10)->default('active');
            $table->foreignId('nursery_id');
            $table->foreignId('species_id');
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
        Schema::dropIfExists('batch_infos');
    }
};
