<?php


namespace App\Service;


use App\Models\Address;

class AddressService
{

    public function findOrCreateAddres(string $country, string $city): Address
    {
        $address = Address::where('country', $country)
            ->where('city', $city)->first();
        if(!$address) {
            $address = Address::create([
                'country' => $country,
                'city' => $city
            ]);
        }
        return $address;
    }

}
