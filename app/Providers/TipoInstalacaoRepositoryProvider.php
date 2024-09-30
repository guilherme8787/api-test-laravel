<?php

namespace App\Providers;

use App\Repositories\TipoInstalacao\TipoInstalacaoRepository;
use App\Repositories\TipoInstalacao\TipoInstalacaoRepositoryContract;
use Illuminate\Support\ServiceProvider;

class TipoInstalacaoRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            TipoInstalacaoRepositoryContract::class,
            TipoInstalacaoRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): array
    {
        return [
            TipoInstalacaoRepositoryContract::class,
        ];
    }
}
