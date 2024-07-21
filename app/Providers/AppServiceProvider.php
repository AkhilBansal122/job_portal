<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\SectionRepository;
use App\Repositories\Interfaces\SectrionRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            SectrionRepositoryInterface::class,
            SectionRepository::class,
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
