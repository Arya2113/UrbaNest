<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\Api\ApiAuthController;


Route::get('/properties', [ApiAuthController::class, 'getAllPropertiesApi']);


Route::post('/login', [ApiAuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [ApiAuthController::class, 'logout']);
    Route::get('/user', fn (Request $request) => $request->user());
    Route::get('/property/{id}/checkout', [ApiAuthController::class, 'checkout']);
    Route::post('/property/{id}/upload-proof', [ApiAuthController::class, 'uploadProof']);
    Route::get('/favorites', [ApiAuthController::class, 'getFavorites']);
    Route::post('/favorites/toggle/{property}', [ApiAuthController::class, 'toggleFavorite']);
    Route::get('/transactions/history', [ApiAuthController::class, 'getTransactionHistory']);
    Route::get('/checkout/{transactionId}', [ApiAuthController::class, 'getCheckoutTransactionById']);

});

Route::post('/register', [ApiAuthController::class, 'register']);

