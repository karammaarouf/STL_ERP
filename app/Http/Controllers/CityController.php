<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\State;
use App\Services\CityService;
use App\Http\Requests\StoreCityRequest;
use App\Http\Requests\UpdateCityRequest;

class CityController extends Controller
{
    protected $cityService;

    public function __construct(CityService $cityService)
    {
        $this->cityService = $cityService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->can('view-city')) {
            abort(403, 'Unauthorized action.');
        }

        $cities = $this->cityService->getAllCities();
        return view('pages.cities.index', compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->can('create-city')) {
            abort(403, 'Unauthorized action.');
        }

        $states = State::all();
        return view('pages.cities.partials.create', compact('states'));
    }

    /**
     * Store a newly created resource in storage.
     */
 // في ملف Controller الخاص بالمدن (مثلاً CityController.php)


public function store(StoreCityRequest $request)
{
    if (!auth()->user()->can('create-city')) {
        abort(403, 'Unauthorized action.');
    }

    $city = $this->cityService->createCity($request->validated());

    if ($request->wantsJson()) {
        return response()->json($city, 201);
    }

    return redirect()->route('cities.index')
        ->with('success', __('City created successfully.'));
}

    /**
     * Display the specified resource.
     */
    public function show(City $city)
    {
        if (!auth()->user()->can('show-city')) {
            abort(403, 'Unauthorized action.');
        }

        return view('pages.cities.partials.show', compact('city'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(City $city)
    {
        if (!auth()->user()->can('edit-city')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->wantsJson()) {
            return response()->json($city);
        }

        $states = State::all();
        return view('pages.cities.partials.edit', compact('city', 'states'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCityRequest $request, City $city)
    {
        if (!auth()->user()->can('edit-city')) {
            abort(403, 'Unauthorized action.');
        }

        $updatedCity = $this->cityService->updateCity($city, $request->validated());

        if ($request->wantsJson()) {
            return response()->json($updatedCity);
        }

        return redirect()->route('cities.index')
            ->with('success', __('City updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(City $city)
    {
        if (!auth()->user()->can('delete-city')) {
            abort(403, 'Unauthorized action.');
        }

        $this->cityService->deleteCity($city);
        return redirect()->back()
            ->with('success', __('City deleted successfully.'));
    }

    public function getCitiesForState(State $state)
    {

       if (!auth()->user()->can('view-city')) {
            abort(403, 'Unauthorized action.');
        }
        return response()->json($state->cities()->orderBy('name')->get());
    }
}
