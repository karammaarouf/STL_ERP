<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityController;
use App\Http\Controllers\StateController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
    // Route to get states for a specific country

});




Route::middleware(['auth'])->group(function () {

Route::get('/countries/{country}/states', [StateController::class, 'getStatesForCountry']);
Route::get('/states/{state}/cities', [CityController::class, 'getCitiesForState']);


});
