<?php

namespace App\Providers;

use App\Services\Customer\CustomerService;
use App\Services\Customer\Contracts\CustomerServiceContract;
use Illuminate\Support\ServiceProvider;

class CustomerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            CustomerServiceContract::class,
            CustomerService::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): array
    {
        return [
            CustomerServiceContract::class,
        ];
    }
}
