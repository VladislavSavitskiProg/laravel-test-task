<?php

namespace App\Providers;

use App\Services\Imports\BookingImportingFromCsv;
use App\Services\Imports\CapacityImportingFromCsv;
use Illuminate\Support\ServiceProvider;

class DataImportingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(\App\Contracts\Bookings\BookingImportingFromCsv::class, BookingImportingFromCsv::class);
        $this->app->bind(\App\Contracts\Capacities\CapacityImportingFromCsv::class, CapacityImportingFromCsv::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

    }
}
