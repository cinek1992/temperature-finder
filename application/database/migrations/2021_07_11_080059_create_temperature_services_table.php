<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemperatureServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temperature_services', function (Blueprint $table) {
            $table->bigInteger('temperature_id', false, true);
            $table->foreign('temperature_id')->references('id')->on('temperatures');
            $table->bigInteger('service_id', false, true);
            $table->foreign('service_id')->references('id')->on('services');
            $table->bigInteger('temperature_type_id', false, true);
            $table->foreign('temperature_type_id')->references('id')->on('temperature_types');
            $table->float('value');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('temperature_services');
    }
}
