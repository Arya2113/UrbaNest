<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PropertyController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/detailproperti/{property}', [PropertyController::class, 'show'])->name('property.show');

Route::get('/cariproperti', [PropertyController::class, 'index'])->name('cariproperti.index');

