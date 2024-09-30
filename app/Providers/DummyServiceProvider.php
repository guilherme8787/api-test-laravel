<?php

namespace App\Providers;

use App\Services\Dummy\DummyService;
use App\Services\Dummy\Contracts\DummyServiceContract;
use Illuminate\Support\ServiceProvider;

class DummyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            DummyServiceContract::class,
            DummyService::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): array
    {
        return [
            DummyServiceContract::class,
        ];
    }
}
