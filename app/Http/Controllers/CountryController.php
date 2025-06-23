<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCountryRequest;
use App\Http\Requests\UpdateCountryRequest;
use App\Models\Country;
use App\Services\CountryService;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    protected $countryService;

    public function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
        // $this->middleware('permission:view-country', ['only' => ['index']]);
        // $this->middleware('permission:create-country', ['only' => ['create', 'store']]);
        // $this->middleware('permission:edit-country', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:delete-country', ['only' => ['destroy']]);
    }

    public function index()
    {
        $countries = $this->countryService->getAllCountries();
        return view('pages.countries.index', compact('countries'));
    }

    public function create()
    {
        return view('pages.countries.partials.create');
    }

    public function store(StoreCountryRequest $request)
    {
        $this->countryService->createCountry($request->validated());
        return redirect()->route('countries.index')->with('success', 'Country created successfully.');
    }

    public function show(Country $country)
    {
        return view('countries.show', compact('country'));
    }

    public function edit(Country $country)
    {
        return view('countries.edit', compact('country'));
    }

    public function update(UpdateCountryRequest $request, Country $country)
    {
        $this->countryService->updateCountry($country, $request->validated());
        return redirect()->route('countries.index')->with('success', 'Country updated successfully.');
    }

    public function destroy(Country $country)
    {
        $this->countryService->deleteCountry($country);
        return redirect()->route('countries.index')->with('success', 'Country deleted successfully.');
    }
}
