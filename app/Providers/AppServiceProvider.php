<?php

namespace App\Providers;

use App\Interfaces\ApiServiceInterface;
use App\Interfaces\FetchNewsServiceInterface;
use App\Interfaces\NewsRepositoryInterface;
use App\Interfaces\NewsServiceInterface;
use App\Repositories\NewsRepository;
use App\Services\ApiService;
use App\Services\FetchNewsService;
use App\Services\NewsService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind(FetchNewsServiceInterface::class,
            FetchNewsService::class);

        $this->app->bind(NewsServiceInterface::class,
            NewsService::class);

        $this->app->bind(ApiServiceInterface::class,
            ApiService::class);

    }
}
