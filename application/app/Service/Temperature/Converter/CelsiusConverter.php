<?php


namespace App\Service\Temperature\Converter;


use App\Constants\TemperatureConstants;

class CelsiusConverter extends TemperatureConverter
{

    public function toCelsius(float $temperature): float
    {
        return $temperature;
    }

    public function toKelvin(float $temperature): float
    {
        return $temperature + TemperatureConstants::CELSIUS_ABSOLUTE_ZERO;
    }

    public function toFahrenheit(float $temperature): float
    {
        return $temperature * TemperatureConstants::FAHRENHEIT_MULTIPLIER + TemperatureConstants::FAHRENHEIT_OFFSET;
    }

}
