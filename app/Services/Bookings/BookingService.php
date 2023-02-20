<?php

namespace App\Services\Bookings;

use App\Actions\Bookings\UpdateStatusesAction;

class BookingService
{
    public function __construct(
        private readonly UpdateStatusesAction $updateStatuses,
    ) {}

    public function updateStatuses(): void
    {
        $this->updateStatuses->handle();
    }
    public function calculate()
    {

    }
}
