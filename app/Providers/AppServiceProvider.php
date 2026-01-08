<?php

namespace App\Providers;

use App\Contracts\LinkRepositoryInterface;
use App\Contracts\MessageRepositoryInterface;
use App\Repositories\LinkRepository;
use App\Repositories\MessageRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            LinkRepositoryInterface::class,
            LinkRepository::class
        );

        $this->app->bind(
            MessageRepositoryInterface::class,
            MessageRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
