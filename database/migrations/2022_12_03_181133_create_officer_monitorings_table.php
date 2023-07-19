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
        Schema::create('officer_monitorings', function (Blueprint $table) {
            $table->id('monitor_id');
            $table->date('date_monitored');
            $table->decimal('longitude', 9, 6);
            $table->decimal('latitude', 8, 6);
            $table->string('address', 50);
            $table->string('species', 50)->nullable();
            $table->string('area', 10);
            $table->string('spacing', 4);
            $table->tinyInteger('no_plots');
            $table->mediumInteger('total_planted');
            $table->smallInteger('no_survived');
            $table->smallInteger('no_dead');
            $table->tinyInteger('survival_rate');
            $table->string('remarks', 50)->nullable();
            $table->binary('attachment')->nullable();
            $table->foreignId('plantation_id');
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
        Schema::dropIfExists('officer_monitorings');
    }
};
