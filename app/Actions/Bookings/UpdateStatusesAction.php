<?php

namespace App\Actions\Bookings;

use App\Contracts\Actions\ActionInterface;
use App\Contracts\Bookings\BookingRepositoryInterface;
use App\Contracts\Capacities\CapacityRepositoryInterface;
use App\Enums\Bookings\StatusTypes;
use App\Models\Booking;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class UpdateStatusesAction  implements ActionInterface
{
    public function __construct(
        private readonly CapacityRepositoryInterface $capacityRepository,
        private readonly BookingRepositoryInterface $bookingRepository
    ) {}

    public function handle()
    {
        Log::channel('bookings-update-statuses')->info('start of updating statuses');

        $approvedBookingIds = [];
        $rejectedBookingIds = [];

        $this->bookingRepository->getWithNullStatus(function ($booking) use (&$approvedBookingIds, &$rejectedBookingIds) {
            if ($this->isBookingApproved($booking)) {
                $approvedBookingIds[] = $booking->id;
                Log::channel('bookings-update-statuses')->info('approve');
            } else {
                $rejectedBookingIds[] = $booking->id;
                Log::channel('bookings-update-statuses')->info('reject');
            }
        });

        $this->updateBookingStatuses($approvedBookingIds, $rejectedBookingIds);

        Log::channel('bookings-update-statuses')->info('finish of updating statuses');

        return true;
    }

    protected function updateBookingStatuses($approvedBookingIds, $rejectedBookingIds): void
    {
        $this->bookingRepository->updateStatuses($approvedBookingIds, StatusTypes::APPROVED);
        $this->bookingRepository->updateStatuses($rejectedBookingIds, StatusTypes::REJECTED);
    }

    protected function isBookingApproved(Booking $booking): bool
    {
        $hotelId = $booking->hotel_id;
        $arrivalDate = Carbon::parse($booking->arrival_date);
        $cntNights = $booking->nights;
        $lastNight = Carbon::parse($booking->arrival_date)->addDays($cntNights - 1);

        $availableDates = $this->capacityRepository->getAvailableDates(
            $hotelId,
            $arrivalDate,
            $lastNight
        );

        $cntAvlavleDates = count($availableDates);

        Log::channel('bookings-update-statuses')->info("booking {$booking->id}", [
            'hotel id' => $hotelId,
            'arrival date' => $arrivalDate,
            'nights' => $cntNights,
            'last night' => $lastNight,
            'count of avaliable days' => $cntAvlavleDates
        ]);

        if ($cntAvlavleDates === $cntNights) {
            $this->capacityRepository->decrementCapacity($availableDates);
            return true;
        }

        return false;
    }
}
