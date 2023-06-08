<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAgentpublicIdToMemoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('memories', function (Blueprint $table) {
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
        Schema::table('memories', function (Blueprint $table) {
            $table->dropColumn('agentpublic_id');
        });
    }
}
