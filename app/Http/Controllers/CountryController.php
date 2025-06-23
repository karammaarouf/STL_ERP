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

    }

    public function index()
    {
        if (!auth()->user()->can('view-country')) {
            abort(403);
        }
        $countries = $this->countryService->getAllCountries();
        return view('pages.countries.index', compact('countries'));
    }

    public function create()
    {
        if (!auth()->user()->can('create-country')) {
            abort(403);
        }
        return view('pages.countries.partials.create');
    }

    public function store(StoreCountryRequest $request)
    {
        $this->countryService->createCountry($request->validated());
        return redirect()->route('countries.index')->with('success', 'Country created successfully.');
    }

    public function show(Country $country)
    {
        if (!auth()->user()->can('show-country')) {
            abort(403);
        }
        return view('pages.countries.partials.show', compact('country'));
    }

    public function edit(Country $country)
    {
        if (!auth()->user()->can('edit-country')) {
            abort(403);
        }
        return view('pages.countries.partials.edit', compact('country'));
    }

    public function update(UpdateCountryRequest $request, Country $country)
    {

        $this->countryService->updateCountry($country, $request->validated());
        return redirect()->route('countries.index')->with('success', 'Country updated successfully.');
    }

    public function destroy(Country $country)
    {
        if (!auth()->user()->can('delete-country')) {
            abort(403);
        }
        $this->countryService->deleteCountry($country);
        return redirect()->route('countries.index')->with('success', 'Country deleted successfully.');
    }
}
