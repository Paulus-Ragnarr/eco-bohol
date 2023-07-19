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
        Schema::create('manager_monitorings', function (Blueprint $table) {
            $table->id('monitor_id');
            $table->date('date_monitored');
            $table->smallInteger('no_survived');
            $table->smallInteger('no_dead');
            $table->smallInteger('no_replanted');
            $table->string('area', 10);
            $table->string('remarks', 50)->nullable();
            $table->foreignId('plantation_id');
            $table->foreignId('manager_id');
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
        Schema::dropIfExists('manager_monitorings');
    }
};
