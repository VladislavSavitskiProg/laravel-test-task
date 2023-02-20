<?php

namespace App\Providers;

use App\Contracts\Bookings\BookingRepositoryInterface;
use App\Contracts\Capacities\CapacityRepositoryInterface;
use App\Contracts\Hotels\HotelRepositoryInterface;
use App\Repositories\BookingRepository;
use App\Repositories\CapacityRepository;
use App\Repositories\HotelRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(HotelRepositoryInterface::class, HotelRepository::class);
        $this->app->bind(CapacityRepositoryInterface::class, CapacityRepository::class);
        $this->app->bind(BookingRepositoryInterface::class, BookingRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

    }
}
