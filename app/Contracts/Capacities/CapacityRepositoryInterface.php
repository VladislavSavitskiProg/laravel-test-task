<?php

namespace App\Contracts\Capacities;

interface CapacityRepositoryInterface
{
    public function getAvailableDates($hotelId, $startDate, $endDate);
    public function decrementCapacity($capacityIds);
}
