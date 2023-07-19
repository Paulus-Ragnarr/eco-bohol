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
        Schema::table('attachments', function (Blueprint $table) {
            $table->mediumInteger('file_id')->nullable();
            $table->dropColumn('project_id');
            $table->dropColumn('plantation_id');
            $table->dropColumn('resjournal_id');
            $table->dropColumn('stakeholder_id');
            $table->dropColumn('monitor_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
