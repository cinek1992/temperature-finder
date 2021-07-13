<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \Illuminate\Support\Facades\DB;
use \App\Constants\TemperatureTypes;

class CreateTemperatureTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temperature_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
        foreach (config('temperatureformat.formats') as $temperatureType => $class) {
            DB::table('temperature_types')->insert([
                ['name' => $temperatureType]
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('temperature_types');
    }
}
