<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobsController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/jobs', [JobsController::class, 'index'])->name('jobs');
Route::get('/jobs/detail/{id}', [JobsController::class, 'detail'])->name('jobDetail');
Route::post('/jobs/apply/{id}', [JobsController::class, 'applyJob'])->name('jobApply');

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
        Route::put('/update-profile', [AuthController::class, 'updateProfile'])->name('account.updateProfile');
        Route::put('/update-profile-pic', [AuthController::class, 'updateProfilePic'])->name('account.updateProfilePic');
        Route::get('/create-job', [AuthController::class, 'createJob'])->name('account.createJob');
        Route::post('/save-job', [AuthController::class, 'saveJob'])->name('account.saveJob');
        Route::get('/index-job', [AuthController::class, 'indexJob'])->name('account.indexJob');
        Route::get('/index-job/edit/{jobId}', [AuthController::class, 'editJob'])->name('account.editJob');
        Route::put('/index-job/update-job/{jobId}', [AuthController::class, 'updateJob'])->name('account.updateJob');
        Route::delete('/index-job/delete-job/{jobId}', [AuthController::class, 'deleteJob'])->name('account.deleteJob');
        Route::get('/logout', [AuthController::class, 'logout'])->name('account.logout');
    });
});
