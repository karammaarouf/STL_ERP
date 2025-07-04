<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        if (!auth()->user()->can('view-country')) { // You can create a general permission like 'view-locations'
            abort(404);
        }

        $countries = Country::orderBy('name')->get();
        return view('pages.locations.index', compact('countries'));
    }

    // In CountryController.php, StateController.php, CityController.php


}
