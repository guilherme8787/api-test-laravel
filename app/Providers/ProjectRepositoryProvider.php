<?php

namespace App\Providers;

use App\Repositories\Project\ProjectRepository;
use App\Repositories\Project\ProjectRepositoryContract;
use Illuminate\Support\ServiceProvider;

class ProjectRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            ProjectRepositoryContract::class,
            ProjectRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): array
    {
        return [
            ProjectRepositoryContract::class,
        ];
    }
}
