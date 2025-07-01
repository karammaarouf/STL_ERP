<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\WarehouseZoneController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WarehouseSectionController;
use App\Http\Controllers\WarehouseRackController;
use App\Http\Controllers\WarehouseSlotController;
use App\Http\Controllers\PalletController;
use App\Http\Controllers\Api\WarehouseController as ApiWarehouseController;
use App\Http\Controllers\Api\ZoneController as ApiZoneController;
use App\Http\Controllers\Api\SectionController as ApiSectionController;
use App\Http\Controllers\Api\RackController as ApiRackController;
use App\Http\Controllers\Api\StateController as ApiStateController;
use App\Http\Controllers\Api\CountryController as ApiCountryController;
use App\Http\Controllers\Api\PalletController as ApiPalletController;

Route::middleware(['guest'])->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    });
});


Route::middleware(['auth'])->group(function () {

    Route::get('/', function () {
        return view('layouts.app');
    })->name('dashboard');
    Route::resource('users', UserController::class);

    Route::resource('countries', CountryController::class);
    Route::resource('states', StateController::class);
    Route::resource('cities', CityController::class);
    Route::get('/locations', [LocationController::class, 'index'])->name('locations.index');

    Route::resource('warehouses', WarehouseController::class);
    Route::resource('warehouse-zones', WarehouseZoneController::class);
    Route::resource('warehouse-sections', WarehouseSectionController::class);
    Route::resource('warehouse-racks', WarehouseRackController::class);
    Route::resource('warehouse-slots', WarehouseSlotController::class);
    Route::resource('pallets', PalletController::class);

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])
        ->name('users.toggle-status')
        ->middleware('can:edit-user');

    Route::prefix('api')->group(function () {
        Route::get('/countries/{country}/states', [StateController::class, 'getStatesForCountry']);
        Route::get('/states/{state}/cities', [CityController::class, 'getCitiesForState']);
        Route::get('/warehouses/search', [ApiWarehouseController::class, 'search'])->name('api.warehouses.search');
        Route::get('/zones/search', [ApiZoneController::class, 'search'])->name('api.zones.search');
        Route::get('/sections/search', [ApiSectionController::class, 'search'])->name('api.sections.search');
        Route::get('/racks/search', [ApiRackController::class, 'search'])->name('api.racks.search');
        Route::get('/states/search', [ApiStateController::class, 'search'])->name('api.states.search');
        Route::get('/countries/search', [ApiCountryController::class, 'search'])->name('api.countries.search');
        Route::get('/cities/search', [CityController::class, 'search'])->name('api.cities.search');
        Route::get('/pallets/search', [ApiPalletController::class, 'search'])->name('api.pallets.search');
    });
});

require __DIR__ . '/auth.php';
