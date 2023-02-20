<?php

namespace App\Actions\Statistic;

use App\Contracts\Actions\ActionInterface;
use App\Contracts\Bookings\BookingRepositoryInterface;
use App\Contracts\Tasks\TaskInterface;
use Illuminate\Support\Collection;

class Task3Action implements ActionInterface, TaskInterface
{
    public function __construct(
        private readonly BookingRepositoryInterface $bookingRepository,
    ) {}

    public function handle(): Collection
    {
        return $this->bookingRepository->getMostUnluckyCustomers();
    }

    public function getName(): string {
        return 'task3';
    }
}
