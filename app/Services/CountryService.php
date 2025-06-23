<?php

namespace App\Services;

use App\Models\Country;

class CountryService
{
    public function getAllCountries()
    {
        return Country::latest()->paginate(10);
    }

    public function createCountry(array $data)
    {
        return Country::create($data);
    }

    public function getCountryById($id)
    {
        return Country::findOrFail($id);
    }

    public function updateCountry(Country $country, array $data)
    {
        $country->update($data);
        return $country;
    }

    public function deleteCountry(Country $country)
    {
        $country->delete();
    }
}
