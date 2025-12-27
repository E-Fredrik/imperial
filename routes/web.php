<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\InfoController;
use App\Http\Controllers\Admin\RoomFacilityController;
use App\Http\Controllers\Admin\KostFacilityController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Admin\AdminBookingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\RoomDisplayController;
use App\Http\Controllers\PaymentController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/rooms', [RoomDisplayController::class, 'index'])->name('rooms');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Midtrans webhook (no auth required)
Route::post('/payment/webhook', [PaymentController::class, 'webhook'])->name('payment.webhook');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
    
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::resource('bookings', BookingController::class)->only(['index','create','store','show','destroy']);
    
    // User payment routes - FIXED: Changed to GET for finish route
    Route::get('/payment/{payment}', [PaymentController::class, 'show'])->name('payment.show');
    Route::get('/payment/finish/callback', [PaymentController::class, 'finish'])->name('payment.finish');
    Route::get('/payments/upcoming', [PaymentController::class, 'upcoming'])->name('payments.upcoming');
});

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::resource('rooms', RoomController::class);
    Route::resource('info', InfoController::class);
    Route::resource('roomfac', RoomFacilityController::class);
    Route::resource('kostfac', KostFacilityController::class);
    Route::resource('bookings', AdminBookingController::class);
    Route::resource('images', ImageController::class);
    Route::post('images/{image}/toggle-featured', [ImageController::class, 'toggleFeatured'])->name('images.toggleFeatured');
    Route::post('bookings/{booking}/decline', [AdminBookingController::class, 'decline'])->name('bookings.decline');
    Route::resource('payments', AdminPaymentController::class);
});

require __DIR__.'/auth.php';
