<?php

namespace App\Providers;

use App\Repositories\Localization\LocalizationRepository;
use App\Repositories\Localization\LocalizationRepositoryContract;
use Illuminate\Support\ServiceProvider;

class LocalizationRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            LocalizationRepositoryContract::class,
            LocalizationRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): array
    {
        return [
            LocalizationRepositoryContract::class,
        ];
    }
}
