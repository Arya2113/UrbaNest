<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/detailproperti/{property}', [PropertyController::class, 'show'])->name('property.show');
Route::get('/cariproperti', [PropertyController::class, 'index'])->name('cariproperti.index');

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

// Payment Detail View Route (Placeholder - this will be replaced/modified)
// Route::get('/paymentdetail', function () {
//     return view('paymentdetail');
// })->name('paymentdetail');

// Checkout Route
Route::post('/property/{property}/checkout', [PropertyController::class, 'checkout'])->name('property.checkout');