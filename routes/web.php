<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BarberController;
use App\Http\Controllers\BookingController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landingpage.index');
})->name('landingpage.index');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::middleware(['auth', 'verified'])->group(function(){
    Route::get('home', function(){
        // return view('dashboard.home');
        $user = Auth::user();
        if ($user->role == 'user') {
            return redirect()->route('landingpage.index');
        } elseif (in_array($user->role, ['barber', 'admin'])) {
            return view('dashboard.home');
        } else {
            abort(403, 'Unauthorized action.');
        }
    })->name('home');

    Route::get('edit-profile', function(){
        return view('dashboard.profile');
    })->name('profile.edit');

    Route::resource('user', UserController::class);
    // Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    // Route::post('/user', [UserController::class, 'store'])->name('user.store');
    // Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    // Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
    // Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');
    Route::put('/profile/updatePicture', [App\Http\Controllers\UserController::class, 'updatePicture'])->name('profile.updatePicture');


    Route::get('/customer/mybooking', [BookingController::class, 'index'])->name('booking.index');
    Route::get('/booking/create', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');
    // Route::get('/customer/mybooking/{booking}/detail', [BookingController::class, 'show'])->name('booking.show');
    Route::get('/customer/booking/{booking}', [BookingController::class, 'show'])->name('booking.show');
    Route::get('/barber/available-schedule', [BookingController::class, 'availableSchedule'])->name('barber.availableSchedule');
    Route::get('/barber/available-services', [BookingController::class, 'availableServices'])->name('barber.availableServices');


    // Route untuk barber
        
    // Tambahkan route untuk fitur barber di sini
    Route::get('/barber', [BarberController::class, 'index'])->name('barber.index');
    Route::get('/barber/schedule', [BarberController::class, 'schedule'])->name('barber.schedule');
    // Route::post('/barber/set-schedule', [BarberController::class, 'setSchedule'])->name('barber.setSchedule');
    Route::post('/barber/schedule', [BarberController::class, 'setSchedule'])->name('barber.setSchedule');
    Route::get('/barber/price', [BarberController::class, 'Price'])->name('barber.Price');
    Route::post('/barber/price', [BarberController::class, 'setPrice'])->name('barber.setPrice');


    // Route Artikel
    Route::resource('articles', ArticleController::class);


});