<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCvIdToCvStatuses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function change()
    {
        Schema::table('cv_statuses', function (Blueprint $table) {
            $table->unsignedBigInteger('cv_id');
            $table->foreign('cv_id')->references('id')->on('cvs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cv_statuses', function (Blueprint $table) {
            $table->dropForeign(['cv_id']);
            $table->dropColumn('cv_id');
        });
    }
}
