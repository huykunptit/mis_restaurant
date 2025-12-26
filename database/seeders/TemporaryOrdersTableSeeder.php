<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\TemporaryOrder;
use App\Models\User;
use App\Models\Menu;
use App\Models\MenuOption;

class TemporaryOrdersTableSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create();
        $userIds = User::pluck('id')->toArray();
        $menuIds = Menu::pluck('id')->toArray();
        $menuOptionIds = MenuOption::pluck('id')->toArray();

        for ($i=0;$i<40;$i++){
            TemporaryOrder::factory()->create([
                'user_id' => $faker->randomElement($userIds),
                'menu_id' => $faker->randomElement($menuIds),
                'menu_option_id' => $faker->optional()->randomElement($menuOptionIds),
                'quantity' => $faker->numberBetween(1,4),
                'remarks' => $faker->sentence(),
            ]);
        }
    }
}
