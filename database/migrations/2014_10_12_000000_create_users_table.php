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
        Schema::create('users', function (Blueprint $table) {
            $table->id("user_id");
            $table->string('name', 50);
            $table->string('email', 50)->unique();
            $table->char('user_contact', 12)->nullable();
            $table->string('position', 50)->nullable();
            $table->string('password', 50);
            $table->string('user_role', 12)->nullable();
            $table->string('status', 10)->default('disabled');
            $table->string('office', 20)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
