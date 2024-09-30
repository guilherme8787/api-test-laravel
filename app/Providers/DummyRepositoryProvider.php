<?php

namespace App\Providers;

use App\Repositories\Dummy\DummyRepository;
use App\Repositories\Dummy\DummyRepositoryContract;
use Illuminate\Support\ServiceProvider;

class DummyRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            DummyRepositoryContract::class,
            DummyRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): array
    {
        return [
            DummyRepositoryContract::class,
        ];
    }
}
