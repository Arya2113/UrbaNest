<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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

// Favorite Toggle Route
Route::post('/property/{property}/favorite', [PropertyController::class, 'toggleFavorite'])->name('property.toggleFavorite');


// Checkout Routes
Route::post('/property/{property}/attemptLockAndCheckout', [PropertyController::class, 'attemptLockAndCheckout'])->name('property.attemptLockAndCheckout');
Route::get('/property/{property}/checkout', [PropertyController::class, 'checkout'])->name('property.checkout');
// Payment Upload Route
Route::post('/payment/upload/{property}', [PropertyController::class, 'uploadProof'])->name('payment.upload');
Route::get('/payment/confirmation/{transaction}', [PropertyController::class, 'paymentConfirmation'])
    ->name('payment.confirmation')
    ->middleware('auth');


Route::get('/payment/confirmed/{transactionId}', [PropertyController::class, 'confirmedPage'])->name('payment.confirmed') ->middleware('auth');

// Payment Rejected Route
Route::get('/payment/rejected', function () {
 return view('paymentrejected');
});