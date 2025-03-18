<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'account'], function () {

    // Guest route
    Route::group(['middleware' => 'guest'], function () {
        Route::get('/register', [AuthController::class, 'registration'])->name('account.registration');
        Route::post('/process-register', [AuthController::class, 'processRegistration'])->name('account.processRegistration');

        Route::get('/login', [AuthController::class, 'login'])->name('account.login');
        Route::post('/authenticate', [AuthController::class, 'authenticate'])->name('account.authenticate');
    });

    // Authenticated route
    Route::group(['middleware' => ['auth', 'redirectTo:account.login']], function () {
        Route::get('/profile', [AuthController::class, 'profile'])->name('account.profile');
        Route::match(['PUT', 'POST'], '/update-profile', [AuthController::class, 'updateProfile'])->name('account.updateProfile');
        Route::get('/logout', [AuthController::class, 'logout'])->name('account.logout');
    });
});
