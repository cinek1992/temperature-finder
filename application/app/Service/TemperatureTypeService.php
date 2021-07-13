<?php


namespace App\Service;


use App\Models\TemperatureType;

class TemperatureTypeService
{

    public function findOrCreate(string $temperatureType):TemperatureType
    {
        $type = TemperatureType::where('name', $temperatureType)->first();
        if(!$type) {
            $type = TemperatureType::create(['name' => $temperatureType]);
        }
        return $type;
    }

}
