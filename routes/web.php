<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/account/register', [AuthController::class, 'registration'])->name('account.registration');
Route::post('/account/process-register', [AuthController::class, 'processRegistration'])->name('account.processRegistration');

Route::get('/account/login', [AuthController::class, 'login'])->name('account.login');
