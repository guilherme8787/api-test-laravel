<?php

namespace App\Providers;

use App\Services\Project\ProjectService;
use App\Services\Project\Contracts\ProjectServiceContract;
use Illuminate\Support\ServiceProvider;

class ProjectServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            ProjectServiceContract::class,
            ProjectService::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): array
    {
        return [
            ProjectServiceContract::class,
        ];
    }
}
