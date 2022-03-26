<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class BootstrapServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(\App\Services\UserServiceServiceInterface::class, \App\Services\UserServiceService::class);
        $this->app->bind(\App\Services\CustomerServiceServiceInterface::class, \App\Services\CustomerServiceService::class);
        $this->app->bind(\App\Services\CustomerServiceInterface::class, \App\Services\CustomerService::class);
        $this->app->bind(\App\Services\UserServiceInterface::class, \App\Services\UserService::class);
        $this->app->bind(\App\Services\UserServiceInterface::class, \App\Services\UserService::class);
        //:end-bindings:
    }
}
