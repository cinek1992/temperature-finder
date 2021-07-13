<?php


namespace App\Service\Weather\OpenWeatherMap;

use App\Constants\TemperatureTypes;
use App\DTO\Temperature;
use App\Service\Weather\WeatherService;

class OpenWeatherMapService implements WeatherService
{

    private $apiClient;

    public function __construct(ApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    public function getTemperature(string $country, string $city): ?Temperature
    {
        try {
            $response = $this->apiClient->getTemperature($this->buildQueryToTemperatureSearch($country, $city));
            $data = json_decode($response->getBody()->getContents());
            return new Temperature($data->main->temp, TemperatureTypes::KELVIN);
        } catch (\Exception $e) {
            return null;
        }
    }

    private function buildQueryToTemperatureSearch(string $country, string $city)
    {
        return "$country, $city";
    }

    public function getServiceName(): string
    {
        return config('openweathermap.name');
    }

    public function getServiceUrl(): string
    {
        return config('openweathermap.baseurl');
    }
}
