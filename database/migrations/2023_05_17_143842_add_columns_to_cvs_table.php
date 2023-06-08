<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToCvsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function change()
    {
        Schema::table('cvs', function (Blueprint $table) {
            $table->unsignedBigInteger('cv_status_id');
            $table->foreign('cv_status_id')->references('id')->on('cv_statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cvs', function (Blueprint $table) {
            //
        });
    }
}
