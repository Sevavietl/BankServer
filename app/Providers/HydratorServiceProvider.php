<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use BankServer\Persistence\Laravel\Hydrator\SimpleHydrator;

class HydratorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('BankServer\Persistence\Laravel\Hydrator\HydratorInterface', function($app) {
            return new SimpleHydrator;
        });
    }
}
