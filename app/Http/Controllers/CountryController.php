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

    // في ملف CountryController.php


    public function store(StoreCountryRequest $request)
    {
        if (!auth()->user()->can('create-country')) {
            abort(403, 'Unauthorized action.');
        }

        $country = $this->countryService->createCountry($request->validated());

        if ($request->wantsJson()) {
            return response()->json($country, 201);
        }

        return redirect()->route('countries.index')
            ->with('success', __('Country created successfully.'));
    }

    public function show(Country $country)
    {
        if (!auth()->user()->can('show-country')) {
            abort(403);
        }
        return view('pages.countries.partials.show', compact('country'));
    }
    public function edit(Request $request, Country $country)
    {
        if (!auth()->user()->can('edit-country')) {
            abort(403, 'This action is unauthorized.');
        }

        // هنا التصحيح: نستخدم كائن الطلب $request
        if ($request->wantsJson()) {
            return response()->json(['model' => $country]);
        }

        // هذا السطر سيعمل للطلبات العادية من المتصفح
        return view('pages.countries.partials.edit', compact('country'));
    }

    public function update(UpdateCountryRequest $request, Country $country)
    {
        $this->countryService->updateCountry($country, $request->validated());
        if ($request->wantsJson()) {
            return response()->json(['model' => $country]);
        }
        return redirect()->route('countries.index')->with('success', __('Country updated successfully.'));
    }

    public function destroy(Country $country)
    {
        if (!auth()->user()->can('delete-country')) {
            abort(403);
        }

        $this->countryService->deleteCountry($country);
        return redirect()->route('countries.index')->with('success', __('Country deleted successfully.'));
    }
}
