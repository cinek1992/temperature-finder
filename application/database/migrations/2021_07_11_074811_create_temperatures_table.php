<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemperaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temperatures', function (Blueprint $table) {
            $table->id();
            $table->float('value');
            $table->bigInteger('address_id', false, true);
            $table->foreign('address_id')->references('id')->on('addresses');
            $table->bigInteger('temperature_type_id', false, true);
            $table->foreign('temperature_type_id')->references('id')->on('temperature_types');
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
        Schema::dropIfExists('temperatures');
    }
}
