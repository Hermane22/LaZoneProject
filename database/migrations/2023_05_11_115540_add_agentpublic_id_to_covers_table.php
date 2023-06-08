<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAgentpublicIdToCoversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('covers', function (Blueprint $table) {
            $table->bigInteger('agentpublic_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('covers', function (Blueprint $table) {
            $table->dropColumn('agentpublic_id');
        });
    }
}
