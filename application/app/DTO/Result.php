<?php


namespace App\DTO;


class Result
{

    private float $value;

    private array $serviceTemperatures = [];

    private string $temperatureType;

    private string $country;

    private string $city;

    /**
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
    }

    /**
     * @param float $value
     */
    public function setValue(float $value): void
    {
        $this->value = $value;
    }

    /**
     * @return array
     */
    public function getServiceTemperatures(): array
    {
        return $this->serviceTemperatures;
    }

    /**
     * @param array $serviceTemperatures
     */
    public function setServiceTemperatures(array $serviceTemperatures): void
    {
        $this->serviceTemperatures = $serviceTemperatures;
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

    public function addServiceTemperature(string $service, string $temperaturetype, float $value)
    {
        $serviceTemperature = collect($this->serviceTemperatures)
            ->filter(fn(ServiceTemperature $serviceTemperature) => $serviceTemperature->getService() === $service);
        if ($serviceTemperature->isNotEmpty()) {
            return;
        }
        $this->serviceTemperatures[] = new ServiceTemperature($service, $temperaturetype, $value);
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }

}
