<?php

namespace Database\Factories;

use App\Models\Hotel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'hotel_id' => Hotel::factory(),
            'customer_id' => User::factory(),
            'sales_price' => $this->faker->randomFloat(2, 100, 10000),
            'purchase_price' => $this->faker->randomFloat(2, 50, 8000),
            'arrival_date' => $this->faker->date,
            'purchase_date' => Carbon::now(),
            'nights' => $this->faker->numberBetween(1, 10),
            'status' => null,
        ];
    }
}
