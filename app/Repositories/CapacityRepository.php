<?php

namespace App\Repositories;

use App\Contracts\Capacities\CapacityRepositoryInterface;
use App\Models\Capacity;

class CapacityRepository implements CapacityRepositoryInterface
{
    public function getAvailableDates($hotelId, $startDate, $endDate)
    {
        return Capacity::query()->where('hotel_id', $hotelId)
            ->whereBetween('date', [$startDate, $endDate])
            ->where('capacity', '>', 0)
            ->pluck('id')
            ->toArray();
    }

    public function decrementCapacity($capacityIds): void
    {
        Capacity::query()->whereIn('id', $capacityIds)
            ->lazy()
            ->each(function ($capacity) {
                $capacity->decrement('capacity');
                $capacity->save();
            });
    }
}
