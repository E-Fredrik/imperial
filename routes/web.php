<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\InfoController;
use App\Http\Controllers\Admin\RoomFacilityController;
use App\Http\Controllers\Admin\KostFacilityController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Admin\AdminBookingController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('bookings', BookingController::class)->only(['index','create','store','show','destroy']);
});

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::resource('rooms', RoomController::class);
    Route::resource('info', InfoController::class);
    Route::resource('roomfac', RoomFacilityController::class);
    Route::resource('kostfac', KostFacilityController::class);
    Route::resource('bookings', AdminBookingController::class);

    // // admin payments
    // Route::get('payments', [PaymentController::class,'index'])->name('payments.index');
    // Route::post('payments/{payment}', [PaymentController::class,'update'])->name('payments.update');
});

require __DIR__.'/auth.php';
