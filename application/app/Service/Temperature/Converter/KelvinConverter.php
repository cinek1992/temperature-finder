<?php


namespace App\Service\Temperature\Converter;


use App\Constants\TemperatureConstants;

class KelvinConverter extends TemperatureConverter
{

    public function toCelsius(float $temperature): float
    {
        return $temperature - TemperatureConstants::CELSIUS_ABSOLUTE_ZERO;
    }

    public function toKelvin(float $temperature): float
    {
        return $temperature;
    }

    public function toFahrenheit(float $temperature): float
    {
        return (new CelsiusConverter())->toFahrenheit($this->toCelsius($temperature));
    }

}
