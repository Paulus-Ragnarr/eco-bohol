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
        Schema::create('stakeholders', function (Blueprint $table) {
            $table->id('stakeholder_id');
            $table->string('stakeholder_type', 50);
            $table->string('stakeholder_name', 50);
            $table->string('stakeholder_email', 50)->unique();
            $table->string('contact_num', 50);
            $table->string('stakeholder_pass', 100);
            $table->string('status', 10);
            // $table->binary('endorsement_letter');
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
        Schema::dropIfExists('stakeholders');
    }
};
