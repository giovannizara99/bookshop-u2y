<?php

use Illuminate\Support\Facades\Route;


Route::prefix('authors')->controller(OdpController::class)->group(function () {
    Route::get('', 'index')->middleware(['permission:' . Permission::CONFIGURATION_FORCE]);
    Route::get('{code}', 'show')->middleware(['permission:' . Permission::CONFIGURATION_FORCE]);
});

Route::prefix('books')->controller(UserController::class)->group(function () {
    Route::get('me', 'me');
    Route::put('language', 'updateLanguage');
});
