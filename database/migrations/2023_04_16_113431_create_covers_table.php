<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('covers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('phone_number');
            $table->string('url')->nullable();
            $table->boolean('done')->default(false);
            $table->bigInteger('affectedTo_id')->default(1);
            $table->bigInteger('affectedBy_id')->default(0);
            $table->string('download_pass')->nullable();
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
        Schema::dropIfExists('covers');
    }
}
