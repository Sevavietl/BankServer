<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use BankServer\Domain\Service\ConductTransactionService;

class ConductTransactionServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton('BankServer\Domain\Service\ConductTransactionService', function ($app) {
            return new ConductTransactionService(
                $this->app->make('BankServer\Domain\Repository\TransactionRepositoryInterface'),
                $this->app->make('BankServer\Domain\Repository\UserRepositoryInterface'),
                $this->app->make('BankServer\Domain\Repository\CardRepositoryInterface')
            );
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
