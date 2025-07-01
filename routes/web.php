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
});

require __DIR__ . '/auth.php';
