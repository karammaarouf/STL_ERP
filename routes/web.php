<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    });
});


Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('layouts.app');
    })->name('dashboard');
});

require __DIR__.'/auth.php';
