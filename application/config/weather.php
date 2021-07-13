<?php

use \App\Service\Weather\WeatherApi\WeatherApiService;
use \App\Service\Weather\OpenWeatherMap\OpenWeatherMapService;

return [

    'cachettl' => env('WEATHER_CACHE_TTL', 60),

    'services' => [
        WeatherApiService::class,
        OpenWeatherMapService::class
    ]

];
