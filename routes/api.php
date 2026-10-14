<?php

use App\Http\Controllers\Api\V1\CatalogController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware('throttle:api')->group(function () {
    Route::get('/categories', [CatalogController::class, 'categories']);
    Route::get('/products', [CatalogController::class, 'products']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [CatalogController::class, 'me']);
    });
});
