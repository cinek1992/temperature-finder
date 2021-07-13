<?php


namespace App\DTO;


class ServiceTemperature
{

    private string $service;

    private float $temperature;

    private string $temperatureType;

    /**
     * ServiceTemperature constructor.
     * @param string $service
     * @param float $temperature
     * @param string $temperatureType
     */
    public function __construct(string $service, string $temperatureType, float $temperature)
    {
        $this->service = $service;
        $this->temperature = $temperature;
        $this->temperatureType = $temperatureType;
    }


    /**
     * @return string
     */
    public function getService(): string
    {
        return $this->service;
    }

    /**
     * @param string $service
     */
    public function setService(string $service): void
    {
        $this->service = $service;
    }

    /**
     * @return float
     */
    public function getTemperature(): float
    {
        return $this->temperature;
    }

    /**
     * @param float $temperature
     */
    public function setTemperature(float $temperature): void
    {
        $this->temperature = $temperature;
    }

    /**
     * @return string
     */
    public function getTemperatureType(): string
    {
        return $this->temperatureType;
    }

    /**
     * @param string $temperatureType
     */
    public function setTemperatureType(string $temperatureType): void
    {
        $this->temperatureType = $temperatureType;
    }

}
