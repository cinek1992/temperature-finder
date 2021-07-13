<?php


namespace App\Service\Temperature\Converter;

use App\Constants\TemperatureTypes;

/**
 * Class TemperatureConverter
 * @package App\Service\Temperature\Converter
 */
abstract class TemperatureConverter
{

    /**
     * Convert temperature to Celsius format
     * @param float $temperature
     * @return float
     * @throws UnsupportedTemperatureException
     */
    public abstract function toCelsius(float $temperature): float;

    /**
     * Convert temperature to Kelvin format
     * @param float $temperature
     * @return float
     * @throws UnsupportedTemperatureException
     */
    public abstract function toKelvin(float $temperature);

    /**
     * Convert temperature to Fahrenheit format
     * @param float $temperature
     * @return float
     * @throws UnsupportedTemperatureException
     */
    public abstract function toFahrenheit(float $temperature): float;

    /**
     * Convert temperature for the given temperature type
     * @param float $temperature
     * @param string $temperatureType
     * @return float
     * @throws UnsupportedTemperatureException
     */
    public final function convert(float $temperature, string $temperatureType):float
    {
        switch ($temperatureType) {
            case TemperatureTypes::KELVIN: {
                return $this->toKelvin($temperature);
            }
            case TemperatureTypes::FAHRENHEIT: {
                return $this->toFahrenheit($temperature);
            }
            case TemperatureTypes::CELSIUS: {
                return $this->toCelsius($temperature);
            }
            default: {
                throw new UnsupportedTemperatureException();
            }
        }
    }

}
