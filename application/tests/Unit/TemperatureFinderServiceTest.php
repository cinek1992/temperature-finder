<?php

namespace Tests\Unit;

use App\Constants\TemperatureConstants;
use App\Constants\TemperatureTypes;
use App\Models\Temperature;
use App\Service\Temperature\Converter\CelsiusConverter;
use App\Service\Temperature\Converter\KelvinConverter;
use App\Service\TemperatureFinderService;
use App\Service\Weather\OpenWeatherMap\ApiClient;
use GuzzleHttp\Psr7\Response;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;


class TemperatureFinderServiceTest extends TestCase
{

    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->runDatabaseMigrations();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_no_result_for_city_and_country()
    {
        $resultCount = Temperature::count();
        $this->mockOpenWeatherMapApiEmptyResult();
        $this->mockWeatherApiEmptyResult();
        /**
         * @var TemperatureFinderService $service
         */
        $service = app()->make(TemperatureFinderService::class);
        $result = $service->getTemperature('test','test',TemperatureTypes::KELVIN);
        $this->assertNull($result);
        $resultCountAfterTest = Temperature::count();
        $this->assertEquals($resultCount, $resultCountAfterTest);
    }

    public function test_ignore_missing_temperature_in_one_service()
    {
        $temperaturesDBCount = Temperature::count();
        $temperature = 350.0;
        $this->mockOpenWeatherMapApiTemperature($temperature);
        $this->mockWeatherApiEmptyResult();
        /**
         * @var TemperatureFinderService $service
         */
        $service = app()->make(TemperatureFinderService::class);
        $result = $service->getTemperature('test','test',TemperatureTypes::KELVIN);
        $this->assertEquals($result, $temperature);
        $resultCountAfterTest = Temperature::count();
        $this->assertNotEquals($temperaturesDBCount, $resultCountAfterTest);
        /**
         * @var Temperature $result
         */
        $result = Temperature::latest()->first();
        $this->assertEquals($result->value, $temperature);
        $this->assertTrue($result->services->count() === 1);
        $this->assertTrue($result->services->first()->pivot->value == $temperature);
    }

    public function test_average_temperature()
    {
        $temperaturesDBCount = Temperature::count();
        $temperature1 = random_int(-20, 20);
        $temperature2 = random_int(-20, 20);
        $this->mockOpenWeatherMapApiTemperature((new CelsiusConverter())->toKelvin($temperature1));
        $this->mockWeatherMapTemperature($temperature2);
        /**
         * @var TemperatureFinderService $service
         */
        $service = app()->make(TemperatureFinderService::class);
        $result = $service->getTemperature('test','test',TemperatureTypes::CELSIUS);
        $calculatedTemperature = ($temperature1 + $temperature2)/2;
        $this->assertEquals($result, $calculatedTemperature);
        $resultCountAfterTest = Temperature::count();
        $this->assertNotEquals($temperaturesDBCount, $resultCountAfterTest);
        /**
         * @var Temperature $result
         */
        $result = Temperature::latest()->first();
        $this->assertEquals($result->value, $calculatedTemperature);
        $this->assertTrue($result->services->count() === 2);
        $this->assertEquals($result->services()->where('name', 'openweathermapservice')->first()->pivot->value, (new CelsiusConverter())->toKelvin($temperature1));
        $this->assertEquals($result->services()->where('name', 'weatherapiservice')->first()->pivot->value, $temperature2);
    }

    private function mockOpenWeatherMapApiEmptyResult()
    {
        $this->setupMock(ApiClient::class, 'openweathermap', null, true);
    }

    private function mockWeatherApiEmptyResult()
    {
        $this->setupMock(\App\Service\Weather\WeatherApi\ApiClient::class, 'weatherapi', null, true);
    }

    private function mockOpenWeatherMapApiTemperature(float $temperature)
    {
        $this->setupMock(ApiClient::class, 'openweathermap', $temperature);
    }

    private function mockWeatherMapTemperature(float $temperature)
    {
        $this->setupMock(\App\Service\Weather\WeatherApi\ApiClient::class, 'weatherapi', $temperature);
    }

    private function setupMock($class, $module, $temperature, $empty = false)
    {

        $openWeatherMapApiMock = $this->mock($class);
        $openWeatherMapApiMock->shouldReceive('getTemperature')
            ->andReturn(new Response(
                $status = 200,
                $headers = [],
                $body = str_replace('$$TEMPERATURE$$', $temperature, file_get_contents(base_path("/tests/json/$module/" . ($empty ? 'empty.json' : 'data.json'))))
            ));
    }
}
