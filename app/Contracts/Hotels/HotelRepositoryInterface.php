<?php

namespace App\Contracts\Hotels;

use Illuminate\Support\Collection;

interface HotelRepositoryInterface
{
    public function getAverageRejectionRatePerHotel(): Collection;
}
