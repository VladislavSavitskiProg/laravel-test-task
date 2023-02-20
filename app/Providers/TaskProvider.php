<?php

namespace App\Providers;

use App\Actions\Statistic\Task1Action;
use App\Actions\Statistic\Task2Action;
use App\Actions\Statistic\Task3Action;
use App\Services\Statistic\StatisticService;
use Illuminate\Support\ServiceProvider;

class TaskProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(StatisticService::class, static fn($app) => new StatisticService(
            $app->make(Task1Action::class),
            $app->make(Task2Action::class),
            $app->make(Task3Action::class),
        ));
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
