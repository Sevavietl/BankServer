<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Transaction;
use App\Card;
use App\User;

use BankServer\Domain\Entity\Transaction as TransactionEntity;
use BankServer\Domain\Entity\Card as CardEntity;
use BankServer\Domain\Entity\User as UserEntity;

use BankServer\Persistence\Laravel\Repository\TransactionRepository;
use BankServer\Persistence\Laravel\Repository\CardRepository;
use BankServer\Persistence\Laravel\Repository\UserRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton('BankServer\Domain\Repository\TransactionRepositoryInterface', function ($app) {
            return new TransactionRepository(
                new Transaction,
                $this->app->make('BankServer\Persistence\Laravel\Hydrator\HydratorInterface'),
                new TransactionEntity
            );
        });

        $this->app->singleton('BankServer\Domain\Repository\CardRepositoryInterface', function ($app) {
            return new CardRepository(
                new Card,
                $this->app->make('BankServer\Persistence\Laravel\Hydrator\HydratorInterface'),
                new CardEntity
            );
        });

        $this->app->singleton('BankServer\Domain\Repository\UserRepositoryInterface', function ($app) {
            return new UserRepository(
                new User,
                $this->app->make('BankServer\Persistence\Laravel\Hydrator\HydratorInterface'),
                new UserEntity
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
