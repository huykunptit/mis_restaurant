<?php

namespace Database\Factories;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Factories\Factory;

class MenuFactory extends Factory
{
    protected $model = Menu::class;

    public function definition()
    {
        return [
            'name' => ucfirst($this->faker->words(2, true)),
            'category_id' => null,
            'disable' => $this->faker->randomElement(['yes','no']),
            'thumbnail' => null,
            'pre_order' => $this->faker->boolean(10),
        ];
    }
}
