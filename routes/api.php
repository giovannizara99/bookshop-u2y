<?php

use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\BookController;
use App\Http\Middleware\ApiKeyAuthMiddleware;
use Illuminate\Support\Facades\Route;


Route::middleware(ApiKeyAuthMiddleware::class)->group(function () {
    Route::prefix('authors')->controller(AuthorController::class)->group(function () {
        Route::get('', 'index');
        Route::post('', 'store');
        Route::get('{id}', 'show');
        Route::put('{id}', 'update');
        Route::delete('{id}', 'destroy');
    });

    Route::prefix('books')->controller(BookController::class)->group(function () {
        Route::get('', 'index');
        Route::post('', 'store');
        Route::get('{id}', 'show');
        Route::put('{id}', 'update');
        Route::delete('{id}', 'destroy');
    });
});

