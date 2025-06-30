<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\Api\WarehouseController as ApiWarehouseController;
use App\Http\Controllers\Api\ZoneController as ApiZoneController;
use App\Http\Controllers\Api\SectionController as ApiSectionController;
use App\Http\Controllers\Api\RackController as ApiRackController;
use App\Http\Controllers\Api\StateController as ApiStateController;
use App\Http\Controllers\Api\CountryController as ApiCountryController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
    // Route to get states for a specific country

});




Route::middleware(['auth'])->group(function () {
    Route::get('/countries/{country}/states', [StateController::class, 'getStatesForCountry']);
    Route::get('/states/{state}/cities', [CityController::class, 'getCitiesForState']);
    Route::get('/warehouses/search', [ApiWarehouseController::class, 'search'])->name('api.warehouses.search');
    Route::get('/zones/search', [ApiZoneController::class, 'search'])->name('api.zones.search');
    Route::get('/sections/search', [ApiSectionController::class, 'search'])->name('api.sections.search');
    Route::get('/racks/search', [ApiRackController::class, 'search'])->name('api.racks.search');
    Route::get('/states/search', [ApiStateController::class, 'search'])->name('api.states.search');
    Route::get('/countries/search', [ApiCountryController::class, 'search'])->name('api.countries.search');
    Route::get('/cities/search', [App\Http\Controllers\Api\CityController::class, 'search'])->name('api.cities.search');
});
