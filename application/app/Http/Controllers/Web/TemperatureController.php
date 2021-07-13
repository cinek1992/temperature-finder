<?php


namespace App\Http\Controllers\Web;


use App\Constants\TemperatureTypes;
use App\Http\Requests\ShowTemperatureRequest;
use App\Service\TemperatureFinderService;
use Illuminate\Support\Facades\Cache;

class TemperatureController
{

    private TemperatureFinderService $temperatureFinderService;

    public function __construct(TemperatureFinderService $temperatureFinderService)
    {
        $this->temperatureFinderService = $temperatureFinderService;
    }

    public function index()
    {
        Cache::flush();
        return view('welcome', [
            'country' => '',
            'city' => '',
            'type' => TemperatureTypes::CELSIUS,
            'missing' => false,
            'temperatureTypes' => $this->temperatureFinderService->getTemperatureTypes(),
            'services' => $this->temperatureFinderService->getRegisteredServices()
        ]);
    }

    public function showTemperature(ShowTemperatureRequest $request)
    {
        [
            'country' => $country,
            'city' => $city,
            'type' => $type
        ] = $request->only('country', 'city', 'type');
        $temperature = $this->temperatureFinderService->getTemperature($country, $city, $type);
        $temperatureTypes = $this->temperatureFinderService->getTemperatureTypes();
        $services = $this->temperatureFinderService->getRegisteredServices();
        $missing = $temperature === null;
        return view('welcome', compact('temperature', 'city', 'country', 'temperatureTypes', 'type', 'services', 'missing'));
    }

}
