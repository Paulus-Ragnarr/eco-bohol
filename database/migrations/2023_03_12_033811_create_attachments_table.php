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
        Schema::create('attachments', function (Blueprint $table) {
            $table->id('attachment_id');
            $table->string('attachment')->nullable();
            // options for imageFor:
            // project_attachment
            // letter_of_aggrement_attachment
            $table->string('attachmentFor', 30)->default('project_attachment'); 
            $table->string('attachmentFilename');
            $table->foreignId('project_id')->nullable();
            $table->foreignId('plantation_id')->nullable();
            $table->foreignId('resjournal_id')->nullable();
            $table->foreignId('stakeholder_id')->nullable();
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
        Schema::dropIfExists('attachments');
    }
};
