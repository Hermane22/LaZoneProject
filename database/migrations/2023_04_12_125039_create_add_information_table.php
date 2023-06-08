<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('add_information', function (Blueprint $table) {
            $table->id();
            $table->text('competence');
            $table->text('loisirs');
            $table->text('langue');

            $table->foreignId('cv_id')->constrained('add_information')->onDelete('restrict');;
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
        Schema::dropIfExists('add_information');
    }
}
