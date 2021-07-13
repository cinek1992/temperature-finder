<?php


namespace App\Service\Temperature\Converter;

/**
 * Factory for temperature converters
 * Class TemperatureConverterFactory
 * @package App\Service\Temperature\Converter
 */
class TemperatureConverterFactory
{

    /**
     * Returns a concrete factory for a given temperature type
     * @param string $temperatureType temperature type
     * @return TemperatureConverter|null converter
     */
    public static function create(string $temperatureType): ?TemperatureConverter
    {
        $config  = config('temperatureformat.formats');
        if (isset($config[$temperatureType])) {
            $class = $config[$temperatureType];
            return app()->make($class);
        }
        return null;
    }

}
