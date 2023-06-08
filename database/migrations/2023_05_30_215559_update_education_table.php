<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateEducationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function change()
    {
        Schema::create('education', function (Blueprint $table) {
            $table->id();
            $table->text('annee');
            $table->text('etablissement');
            $table->text('diplome');

            $table->foreignId('cv_id');

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
        //
    }
}
