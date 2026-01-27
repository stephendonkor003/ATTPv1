<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }


public function boot()
{
    Gate::before(function ($user, $ability) {
        return $user->hasPermission($ability);
    });
}

}
