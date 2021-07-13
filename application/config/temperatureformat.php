<?php

use \App\Service\Temperature\Converter\CelsiusConverter;
use \App\Service\Temperature\Converter\KelvinConverter;
use \App\Service\Temperature\Converter\FahrenheitConverter;
use \App\Constants\TemperatureTypes;

return [

    'formats' => [
        TemperatureTypes::CELSIUS => CelsiusConverter::class,
        TemperatureTypes::KELVIN => KelvinConverter::class,
        TemperatureTypes::FAHRENHEIT => FahrenheitConverter::class
    ]

];
