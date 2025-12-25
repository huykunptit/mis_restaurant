<?php

namespace Database\Factories;

use App\Models\TemporaryOrder;
use Illuminate\Database\Eloquent\Factories\Factory;

class TemporaryOrderFactory extends Factory
{
    protected $model = TemporaryOrder::class;

    public function definition()
    {
        return [
            'user_id' => null,
            'menu_id' => null,
            'menu_option_id' => null,
            'quantity' => $this->faker->numberBetween(1,5),
            'remarks' => $this->faker->sentence(),
            // 'table_id' column does not exist in migration — omit here
        ];
    }
}
