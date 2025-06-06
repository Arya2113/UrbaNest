<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\FavoriteController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\PropertyCheckoutController;
use App\Http\Controllers\HistoryController; // Import HistoryController

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/detailproperti/{property}', [PropertyController::class, 'show'])->name('property.show');
Route::get('/cariproperti', [PropertyController::class, 'index'])->name('cariproperti.index');

Route::get('/services', [ServiceController::class, 'index'])->name('services.page');

// Auth Routes
Route::get('/signup', [AuthController::class, 'showSignupForm'])->name('signup');
Route::post('/signup', [AuthController::class, 'signup'])->name('signup.post');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

Route::post('/property/{property}/favorite', [FavoriteController::class, 'toggleFavorite'])->name('property.toggleFavorite');


// Checkout Routes
Route::get('/property/{property}/checkout', [PropertyCheckoutController::class, 'checkout'])->name('property_checkout.checkout');
Route::post('/payment/upload/{property}', [PropertyCheckoutController::class, 'uploadProof'])->name('payment.upload');
Route::post('/property/{property}/attemptLockAndCheckout', [PropertyController::class, 'attemptLockAndCheckout'])->name('property.attemptLockAndCheckout');

Route::get('/payment/confirmation/{transaction}', [PropertyCheckoutController::class, 'paymentConfirmation'])
    ->name('payment.confirmation')
    ->middleware('auth');


Route::get('/payment/confirmed/{transactionId}', [PropertyCheckoutController::class, 'confirmedPage'])->name('payment.confirmed') ->middleware('auth');

Route::get('/payment/rejected/{transactionId}', [PropertyCheckoutController::class, 'paymentRejected'])->name('payment.rejected') ->middleware('auth');

// History Favorite Route
Route::get('/favorite', [FavoriteController::class, 'index'])->name('favorite.index')->middleware('auth');

// History Transaction Route
Route::get('/transactions', [HistoryController::class, 'index'])->name('history.transactions.index')->middleware('auth');