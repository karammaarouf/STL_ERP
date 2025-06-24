<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\UserController;

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
});

require __DIR__ . '/auth.php';



// ... other routes
