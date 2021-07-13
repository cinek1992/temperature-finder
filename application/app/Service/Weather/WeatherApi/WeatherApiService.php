<?php


namespace App\Service\Weather\WeatherApi;

use App\Constants\TemperatureTypes;
use App\DTO\Temperature;
use App\Service\Weather\WeatherService;

class WeatherApiService implements WeatherService
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
            return new Temperature($data->current->temp_c, TemperatureTypes::CELSIUS);
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
        return config('weatherapi.name');
    }

    public function getServiceUrl(): string
    {
        return config('weatherapi.baseurl');
    }

}
