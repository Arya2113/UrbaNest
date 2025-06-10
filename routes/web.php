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
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PropertyVisitController; // Import PropertyVisitController

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/detailproperti/{property}', [PropertyController::class, 'show'])->name('property.show');
Route::get('/cariproperti', [PropertyController::class, 'index'])->name('cariproperti.index');

Route::get('/services', [ServiceController::class, 'index'])->name('services.page');
Route::get('/services/{slug}', [ServiceController::class, 'detail'])->name('service.show');

// Property Visit Route (Moved outside auth middleware)
Route::post('/property/{property}/visit', [PropertyVisitController::class, 'store'])->name('property.visit.store');

Route::middleware('auth')->group(function () {
    Route::get('/services/request/{slug}', [ServiceController::class, 'showForm'])->name('service.request');
    Route::post('/services/request', [ServiceController::class, 'submitRequest'])->name('service.request.submit');

});

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

Route::get('/favorite', [FavoriteController::class, 'index'])->name('favorite.index')->middleware('auth');

Route::get('/transactions', [HistoryController::class, 'index'])->name('history.transactions.index')->middleware('auth');

// Admin Routes (Temporary - No Auth)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/transactions', [AdminController::class, 'index'])->name('transactions.index');
    Route::put('/transactions/{transaction}/status', [AdminController::class, 'updateStatus'])->name('transactions.updateStatus');

    // Property Visit Routes
    Route::get('/property-visits', [AdminController::class, 'propertyVisits'])->name('property_visits.index');
    Route::put('/property-visits/{propertyVisit}/status', [AdminController::class, 'updatePropertyVisitStatus'])->name('property_visits.updateStatus');
});
