<?php


namespace App\Service;


use App\Constants\TemperatureTypes;
use App\DTO\Result;
use App\DTO\Temperature;
use App\Exception\WrongConfigurationException;
use App\Jobs\StoreTemperature;
use App\Service\Temperature\Converter\TemperatureConverterFactory;
use App\Service\Temperature\Converter\UnsupportedTemperatureException;
use App\Service\Weather\WeatherService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/**
 *
 * Class TemperatureFinderService
 * @package App\Service
 */
class TemperatureFinderService
{

    /**
     * @param string $country
     * @param string $city
     * @param string $temperatureType
     * @return float|null
     * @throws UnsupportedTemperatureException
     * @throws \Throwable
     */
    public function getTemperature(string $country, string $city, string $temperatureType): ?float
    {
        $result = new Result();
        $result->setCountry($country);
        $result->setCity($city);
        $result->setTemperatureType($temperatureType);
        $temperatures = [];
        $services = $this->getRegisteredServices();
        throw_if(empty($services), new WrongConfigurationException());
        foreach ($services as $service) {
            $temperature = $this->getTemperatureFromService($service, $country, $city);
            if ($temperature) {
                $converter = TemperatureConverterFactory::create($temperature->getType());
                $temperatureValue = $converter->convert($temperature->getValue(), $temperatureType);
                $temperatures[] = $temperatureValue;
                $result->addServiceTemperature($this->getServiceKey($service), $temperature->getType(), $temperature->getValue());
            }
        }
        if (empty($temperatures)) {
            return null;
        }
        $resultTemperature = round(array_sum($temperatures) / count($temperatures), 1);
        $result->setValue($resultTemperature);
        $result->setTemperatureType($temperatureType);
        dispatch(new StoreTemperature($result));
        return $resultTemperature;
    }

    /**
     * Method that returns a list of all registered services in app
     * @return array list of registered services
     */
    public function getRegisteredServices(): array
    {
        return collect(config('weather.services'))
            ->map(fn($serviceName) => $this->getServiceAsObject($serviceName))
            ->filter(fn($service) => is_object($service))
            ->toArray();
    }

    /**
     * Returns a service object for a given service name
     * @param string $service
     * @return WeatherService|null service object
     */
    public function getServiceAsObject(string $service): ?WeatherService
    {
        try {
            $serviceObject = app()->make($service);
            if (!$serviceObject instanceof WeatherService) {
                Log::debug("Class: $service is not valid " . WeatherService::class . ' implementation!');
                return null;
            }
            return $serviceObject;
        } catch (BindingResolutionException $e) {
            Log::debug("Class: $service is not valid container service!");
            return null;
        }
    }

    /**
     * Returns an array of all temperature types
     * @return array temperature types
     */
    public function getTemperatureTypes(): array
    {
        return array_keys(config('temperatureformat.formats'));
    }

    /**
     * Returns a service cache key
     * @param WeatherService $service
     * @return string cache key
     */
    public function getServiceKey(WeatherService $service): string
    {
        $reflect = new \ReflectionClass($service);
        return trim(strtolower($reflect->getShortName()));
    }

    /**
     * Returns cache key
     * @param WeatherService $service service
     * @param string $country country
     * @param string $city city
     * @return string cache key
     */
    private function getCacheKey(WeatherService $service, string $country, string $city): string
    {
        $country = trim(strtolower($country));
        $city = trim(strtolower($city));
        $serviceCacheKey = $this->getServiceKey($service);
        return base64_encode("$serviceCacheKey.$country.$city");
    }

    /**
     * Returns cached temperature if exists
     * @param WeatherService $service service
     * @param string $country country
     * @param string $city city
     * @return Temperature|null temperature
     */
    private function getCachedTemperature(WeatherService $service, string $country, string $city): ?Temperature
    {
        $cacheKey = $this->getCacheKey($service, $country, $city);
        return Cache::get($cacheKey);
    }

    /**
     * Method put temperature in cache
     * @param WeatherService $service
     * @param string $country
     * @param string $city
     * @param Temperature|null $temperature
     */
    private function cacheResult(WeatherService $service, string $country, string $city, ?Temperature $temperature)
    {
        $ttl = config('weather.cachettl');
        $cacheKey = $this->getCacheKey($service, $country, $city);
        Cache::put($cacheKey, $temperature, $ttl);
    }

    private function getTemperatureFromService(WeatherService $weatherService, string $country, string $city): ?Temperature
    {
        $temperature = $this->getCachedTemperature($weatherService, $country, $city);
        if (!$temperature) {
            $temperature = $weatherService->getTemperature($country, $city);
            $this->cacheResult($weatherService, $country, $city, $temperature);
        }
        return $temperature;
    }

}
