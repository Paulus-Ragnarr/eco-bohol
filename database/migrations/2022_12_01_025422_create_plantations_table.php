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
        Schema::create('plantations', function (Blueprint $table) {
            $table->id('plantation_id');
            $table->string('unique_code', 30);
            $table->string('region', 15);
            $table->string('district', 10)->nullable();
            $table->string('cenro', 12);
            $table->string('penro', 8);
            $table->string('plantation_address', 50);
            $table->string('component', 15);
            $table->string('commodity', 10);
            $table->string('species', 200);
            $table->date('date_started');
            $table->decimal('total_area', 6, 2);
            $table->string('tenure', 15);
            $table->string('fund_source', 15);
            $table->mediumInteger('target_loa');
            $table->tinyInteger('no_loa');
            $table->mediumInteger('target_no');
            $table->mediumInteger('initial_no');
            $table->mediumInteger('density_ha');
            $table->string('status', 15);
            $table->string('remark', 50)->nullable();
            // $table->binary('loa_file')->nullable();
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
        Schema::dropIfExists('plantations');
    }
};
