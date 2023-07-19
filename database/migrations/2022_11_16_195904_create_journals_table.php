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
        Schema::create('journals', function (Blueprint $table) {
            $table->id("resjournal_id"); 
            $table->string("title", 50);
            $table->string("author", 50);
            $table->string("publisher", 50);
            $table->date("date_published");
            //$table->binary("journal_file");
            $table->string("status", 10) ->default('active');
            $table->foreignId("user_id");
            $table->foreignId("species_id");
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
        Schema::dropIfExists('journals');
    }
};
