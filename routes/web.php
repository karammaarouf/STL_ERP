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

Route::middleware(['guest'])->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    });
});


Route::middleware(['auth'])->group(function () {

    Route::get('/', function () {
        return view('layouts.app');
    })->name('dashboard');
    Route::resource('countries', CountryController::class);
    Route::resource('users', UserController::class);
    Route::resource('states', StateController::class);
    Route::resource('cities', CityController::class);
    Route::get('/locations', [LocationController::class, 'index'])->name('locations.index');
    Route::resource('warehouses', WarehouseController::class);
    Route::resource('warehouse-zones', WarehouseZoneController::class);
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
});

require __DIR__ . '/auth.php';



// ... other routes
