<?php

namespace Database\Factories;

use App\Models\MenuOption;
use Illuminate\Database\Eloquent\Factories\Factory;

class MenuOptionFactory extends Factory
{
    protected $model = MenuOption::class;

    public function definition()
    {
        return [
            'menu_id' => null,
            'name' => $this->faker->randomElement(['Nhạt','Vừa','Đậm','Size S','Size L','Không đường','Có đường']),
            'cost' => $this->faker->numberBetween(10000,200000),
        ];
    }
}
