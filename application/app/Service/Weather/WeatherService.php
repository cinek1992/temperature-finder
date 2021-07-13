<?php


namespace App\Service\Weather;

use App\DTO\Temperature;

/**
 * Common interface for all weather services
 * Interface WeatherService
 * @package App\Service
 */
interface WeatherService
{

    /**
     * Returns temperature for the given country and city
     * @param string $country
     * @param string $city
     * @return Temperature|null return null when there is no temperature available for country and city
     */
    public function getTemperature(string $country, string $city): ?Temperature;

    /**
     * Returns name of the service displayed on footer
     * @return string Service name
     */
    public function getServiceName():string;

    /**
     * Returns url address displayed on footer
     * @return string service url address
     */
    public function getServiceUrl():string;

}
