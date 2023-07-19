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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id('acquire_id');
            $table->smallInteger('current_no_potted')->nullable();
            $table->smallInteger('no_acquired')->nullable();
            $table->string('type', 10)->nullable();
            $table->string('remarks', 100)->nullable();
            $table->foreignId('batch_id');
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
        Schema::dropIfExists('purchases');
    }
};
