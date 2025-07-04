<?php

namespace App\Services;

use App\Models\City;
use Illuminate\Http\Request;

class CityService
{
    /**
     * Get all cities with their states.
     */
    public function getAllCities()
    {
        return City::with('state')->latest()->paginate(10);
    }

    /**
     * Create a new city.
     *
     * @param array $data
     * @return City
     */
    public function createCity(array $data): City
    {
        return City::create($data);
    }

    /**
     * Update an existing city.
     *
     * @param City $city
     * @param array $data
     * @return City
     */
    public function updateCity(City $city, array $data): City
    {
        $city->update($data);
        return $city;
    }

    /**
     * Delete a city.
     *
     * @param City $city
     * @return bool|null
     */
    public function deleteCity(City $city): ?bool
    {
        return $city->delete();
    }
}
