<?php

namespace Database\Factories;

use App\Models\Reservation;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{
    protected $model = Reservation::class;

    public function definition()
    {
        return [
            'user_id' => null,
            'table_id' => null,
            'menu_id' => null,
            'menu_option_id' => null,
            'reservation_time' => $this->faker->dateTimeBetween('-30 days', '+30 days'),
            'status' => $this->faker->randomElement(['pending','confirmed','canceled']),
        ];
    }
}
