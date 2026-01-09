<?php

namespace App\Providers;

use App\Contracts\DestinationRepositoryInterface;
use App\Contracts\LinkRepositoryInterface;
use App\Contracts\MessageRepositoryInterface;
use App\Contracts\SnippetRepositoryInterface;
use App\Repositories\DestinationRepository;
use App\Repositories\LinkRepository;
use App\Repositories\MessageRepository;
use App\Repositories\SnippetRepository;
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
            DestinationRepositoryInterface::class,
            DestinationRepository::class
        );

        $this->app->bind(
            MessageRepositoryInterface::class,
            MessageRepository::class
        );

        $this->app->bind(
            SnippetRepositoryInterface::class,
            SnippetRepository::class
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
