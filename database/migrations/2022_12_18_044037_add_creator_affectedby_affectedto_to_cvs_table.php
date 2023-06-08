<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCreatorAffectedbyAffectedtoToCvsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cvs', function (Blueprint $table) {
            $table->bigInteger('affectedTo_id')->nullable()->after('done');
            $table->bigInteger('affectedBy_id')->nullable()->after('affectedTo_id');
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
            $table->dropColumn('affectedTo_id');
            $table->dropColumn('affectedBy_id');
        });
    }
}
