<?php


namespace App\Service\Temperature\Converter;


use App\Constants\TemperatureConstants;

class FahrenheitConverter extends TemperatureConverter
{

    public function toFahrenheit(float $temperature): float
    {
        return $temperature;
    }

    public function toCelsius(float $temperature): float
    {
        return ($temperature - TemperatureConstants::FAHRENHEIT_OFFSET) / TemperatureConstants::FAHRENHEIT_MULTIPLIER;
    }

    public function toKelvin(float $temperature): float
    {
        return (new CelsiusConverter())->toKelvin($this->toCelsius($temperature));
    }

}
