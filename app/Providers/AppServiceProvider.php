<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\RedirectTo;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Define middleware aliases
        Route::aliasMiddleware('guest', RedirectIfAuthenticated::class);
        Route::aliasMiddleware('redirectTo', RedirectTo::class);

        // ✅ Define the default login route
        Route::get('/login', function () {
            return redirect()->route('account.login');
        })->name('login');

        // used to define bootstrap version
        Paginator::useBootstrapFive();
    }
}
