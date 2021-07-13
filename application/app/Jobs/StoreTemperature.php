<?php

namespace App\Jobs;

use App\DTO\Result;
use App\DTO\ServiceTemperature;
use App\Models\Service;
use App\Models\Temperature;
use App\Service\AddressService;
use App\Service\TemperatureTypeService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class StoreTemperature implements ShouldQueue
{

    private Result $result;

    private AddressService $addressService;

    private TemperatureTypeService $temperatureTypeService;

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Result $result)
    {
        $this->result = $result;
        $this->addressService = app()->make(AddressService::class);
        $this->temperatureTypeService = app()->make(TemperatureTypeService::class);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $address = $this->addressService->findOrCreateAddres($this->result->getCountry(), $this->result->getCity());
        $temperature = new Temperature();
        $temperature->address()->associate($address);
        $temperature->value = $this->result->getValue();
        $temperature->type()
            ->associate(
                $this->temperatureTypeService->findOrCreate($this->result->getTemperatureType()
                )
            );
        $temperature->save();
        foreach ($this->result->getServiceTemperatures() as $serviceTemperature) {
            /**
             * @var ServiceTemperature $serviceTemperature
             */
            $service = $this->getService($serviceTemperature->getService());
            $temperatureType = $this->temperatureTypeService->findOrCreate($serviceTemperature->getTemperatureType());
            $temperature->services()->save($service, [
                'value' => $serviceTemperature->getTemperature(),
                'temperature_type_id' => $temperatureType->id
            ]);
        }
    }

    private function getService(string $serviceName): Service
    {
        $service = Service::where('name', $serviceName)->first();
        if (!$service) {
            $service = Service::create(['name' => $serviceName]);
        }
        return $service;
    }
}
