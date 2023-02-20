<?php

namespace App\Repositories;

use App\Contracts\Bookings\BookingRepositoryInterface;
use App\Enums\Bookings\StatusTypes;
use App\Models\Booking;
use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class BookingRepository implements BookingRepositoryInterface
{
    public function getWithNullStatus($callback)
    {
        Booking::whereNull('status')
            ->orderBy('purchase_date')
            ->orderBy('id')
            ->lazy()
            ->each($callback);
    }

    public function updateStatuses($bookingIds, $status)
    {
        Booking::whereIn('id', $bookingIds)->update(['status' => $status]);
    }

    public function getHotelsWithSmallestWeekendStays(int $limit = 5): Collection
    {
        $stays = [];

        Booking::query()->with('hotel')
            ->where('status', StatusTypes::APPROVED)
            ->orderBy('purchase_date')
            ->orderBy('id')
            ->lazy()
            ->each(function ($booking) use (&$stays) {
                $hotelId = $booking->hotel_id;
                $arrivalDate = Carbon::parse($booking->arrival_date);
                $nights = $booking->nights;
                $departureDate = $arrivalDate->copy()->addDays($nights - 1);

                $stops = 0;
                $period = new CarbonPeriod($arrivalDate, $departureDate);

                foreach ($period as $date) {
                    if ($date->isFriday() || $date->isSaturday()) {
                        $stops++;
                    }
                }

                if (!isset($stays[$hotelId])) {
                    $stays[$hotelId] = [
                        'id' => $hotelId,
                        'name' => $booking->hotel->name,
                        'bookings_count' => 0,
                    ];
                }

                $stays[$hotelId]['bookings_count'] += $stops;
            });

        usort($stays, function ($a, $b) {
            return $a['bookings_count'] <=> $b['bookings_count'];
        });

        return collect(array_slice($stays, 0, 5));
    }


    public function getMostUnluckyCustomers(): Collection
    {
        return Booking::query()->where('status', StatusTypes::REJECTED)
            ->select('customer_id', DB::raw('COUNT(*) as rejects'))
            ->groupBy('customer_id')
            ->orderByDesc('rejects')
            ->orderBy('customer_id')
            ->take(5)
            ->get()
            ->map(function ($booking) {
                return [
                    'customer_id' => $booking->customer_id,
                    'rejects' => $booking->rejects,
                ];
            });
    }
}
