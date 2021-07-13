<?php


namespace App\DTO;

/**
 * An DTO object to represent temperature
 * Class Temperature
 * @package App\Service\Temperature
 */
class Temperature
{
    /**
     * @var string temperature type
     */
    private string $type;

    /**
     * @var float temperature value
     */
    private float $value;

    public function __construct(float $temperature, string $temperatureType)
    {
        $this->type = $temperatureType;
        $this->value = $temperature;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

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

}
