<?php

namespace Tests\Unit;

use App\Enums\Bookings\StatusTypes;
use App\Models\Booking;
use App\Models\Capacity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class UpdateBookingStatusesTest extends TestCase
{
    use RefreshDatabase;

    public function testWithAvailableCapacity()
    {
        $booking = Booking::factory()->create([
            'arrival_date' => '2023-07-01',
            'nights' => 5,
        ]);

        for ($i = 0; $i < 9; $i++)
        {
            Capacity::factory()->create([
                'hotel_id' => $booking->hotel_id,
                'date' => Carbon::parse($booking->arrival_date)->addDays($i - 1),
            ]);
        }

        Artisan::call('bookings:update-statuses');

        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'status' => StatusTypes::APPROVED,
        ]);
    }

    public function testWithNotAvailableCapacity()
    {
        $booking1 = Booking::factory()->create([
            'arrival_date' => '2023-07-01',
            'nights' => 5,
        ]);

        $booking2 = Booking::factory()->create([
            'arrival_date' => '2023-07-15',
            'nights' => 10,
        ]);

        for ($i = 0; $i < 9; $i++)
        {
            Capacity::factory()->create([
                'hotel_id' => $booking1->hotel_id,
                'date' => Carbon::parse($booking1->arrival_date)->addDays($i - 1),
            ]);
        }

        Artisan::call('bookings:update-statuses');

        $this->assertDatabaseHas('bookings', [
            'id' => $booking1->id,
            'status' => StatusTypes::APPROVED,
        ]);

        $this->assertDatabaseHas('bookings', [
            'id' => $booking2->id,
            'status' => StatusTypes::REJECTED,
        ]);
    }

    public function testWithNotExistedAvailableCapacityOfFirstDay()
    {
        $booking = Booking::factory()->create([
            'arrival_date' => '2023-07-01',
            'nights' => 5,
        ]);

        for ($i = 0; $i < 9; $i++)
        {
            Capacity::factory()->create([
                'hotel_id' => $booking->hotel_id,
                'date' => Carbon::parse($booking->arrival_date)->addDays($i - 1),
            ]);
        }

        Capacity::query()->whereDate('date' , $booking->arrival_date)->first()->delete();

        Artisan::call('bookings:update-statuses');

        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'status' => StatusTypes::REJECTED,
        ]);
    }

    public function testWithNotExistedAvailableCapacityOfLastDay()
    {
        $booking = Booking::factory()->create([
            'arrival_date' => '2023-07-01',
            'nights' => 5,
        ]);

        for ($i = 0; $i < 9; $i++)
        {
            Capacity::factory()->create([
                'hotel_id' => $booking->hotel_id,
                'date' => Carbon::parse($booking->arrival_date)->addDays($i - 1),
            ]);
        }

        $lastDate = Carbon::parse($booking->arrival_date)->addDays($booking->nights - 1);

        Capacity::query()->whereDate('date' , $lastDate)->first()->delete();

        Artisan::call('bookings:update-statuses');

        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'status' => StatusTypes::REJECTED,
        ]);
    }

    public function testWithGreaterDemandThanAvailableCapacity()
    {
        $booking1 = Booking::factory()->create([
            'arrival_date' => '2023-07-01',
            'nights' => 9,
        ]);

        $booking2 = Booking::factory()->create([
            'hotel_id' => $booking1->hotel_id,
            'arrival_date' => '2023-07-01',
            'nights' => 9,
        ]);

        $booking3 = Booking::factory()->create([
            'hotel_id' => $booking1->hotel_id,
            'arrival_date' => '2023-07-01',
            'nights' => 9,
        ]);

        for ($i = 0; $i < 10; $i++)
        {
            Capacity::factory()->create([
                'hotel_id' => $booking1->hotel_id,
                'date' => Carbon::parse($booking1->arrival_date)->addDays($i - 1),
                'capacity' => 2
            ]);
        }

        Artisan::call('bookings:update-statuses');

        $this->assertDatabaseHas('bookings', [
            'id' => $booking1->id,
            'status' => StatusTypes::APPROVED,
        ]);

        $this->assertDatabaseHas('bookings', [
            'id' => $booking2->id,
            'status' => StatusTypes::APPROVED,
        ]);

        $this->assertDatabaseHas('bookings', [
            'id' => $booking3->id,
            'status' => StatusTypes::REJECTED,
        ]);
    }

}
