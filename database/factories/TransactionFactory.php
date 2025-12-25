<?php

namespace Database\Factories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition()
    {
        return [
            'user_id' => null,
            'table_id' => null,
            'menu_id' => null,
            'menu_option_id' => null,
            'quantity' => $this->faker->numberBetween(1,6),
            'remarks' => $this->faker->sentence(),
            'completion_status' => $this->faker->randomElement(['pending','completed','cancelled']),
            'payment_status' => $this->faker->randomElement(['unpaid','paid']),
        ];
    }
}
