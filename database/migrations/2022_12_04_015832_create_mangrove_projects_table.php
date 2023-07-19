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
        Schema::create('mangrove_projects', function (Blueprint $table) {
            $table->id('project_id');
            $table->string('project_title', 50);
            $table->string('project_descrp', 100);
            // $table->binary('project_img')->nullable();
            $table->date('date_started');
            $table->date('date_end');
            // $table->binary('project_attachment')->nullable();
            $table->string('proj_status', 12);
            $table->string('status', 10)->default('active');
            $table->foreignId('stakeholder_id');
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
        Schema::dropIfExists('mangrove_projects');
    }
};
