<?php

namespace Database\Factories;

use App\Models\Table;
use Illuminate\Database\Eloquent\Factories\Factory;

class TableFactory extends Factory
{
    protected $model = Table::class;

    public function definition()
    {
        return [
            'table_number' => (string) $this->faker->unique()->numberBetween(1,200),
            'seats' => $this->faker->randomElement([2,4,6,8]),
            'status' => $this->faker->randomElement(['available','reserved','occupied']),
        ];
    }
}
