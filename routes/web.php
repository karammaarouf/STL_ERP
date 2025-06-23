<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountryController;

Route::get('/', function () {
    return view('layouts.app');
});

require __DIR__.'/auth.php';



    // ... other routes
    Route::resource('countries', CountryController::class);


