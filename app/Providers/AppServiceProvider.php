<?php

namespace App\Providers;

use App\Repositories\BookRepository;
use App\Repositories\Contracts\BookRepositoryInterface;
use App\Services\BookService;
use App\Services\Contracts\BookServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            BookRepositoryInterface::class,
            BookRepository::class
        );
        $this->app->bind(
            BookServiceInterface::class,
            BookService::class
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
