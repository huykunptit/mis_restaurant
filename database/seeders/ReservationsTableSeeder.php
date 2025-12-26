<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Table;
use App\Models\Menu;
use App\Models\MenuOption;

class ReservationsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create();
        $userIds = User::pluck('id')->toArray();
        $tableIds = Table::pluck('id')->toArray();
        $menuIds = Menu::pluck('id')->toArray();
        $menuOptionIds = MenuOption::pluck('id')->toArray();

        for ($i=0;$i<25;$i++){
            Reservation::factory()->create([
                'user_id' => $faker->randomElement($userIds),
                'table_id' => $faker->randomElement($tableIds),
                'menu_id' => $faker->optional()->randomElement($menuIds),
                'menu_option_id' => $faker->optional()->randomElement($menuOptionIds),
                'reservation_time' => $faker->dateTimeBetween('+1 days','+30 days'),
                'status' => $faker->randomElement(['pending','confirmed','canceled']),
            ]);
        }
    }
}
