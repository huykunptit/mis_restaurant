<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Menu;
use App\Models\MenuOption;
use Faker\Factory as Faker;

class TransactionsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $userIds = User::pluck('id')->toArray();
        $menuIds = Menu::pluck('id')->toArray();
        $menuOptionIds = MenuOption::pluck('id')->toArray();

        for ($i=0;$i<80;$i++){
            $data = [
                'user_id' => $faker->randomElement($userIds),
                'menu_id' => $faker->randomElement($menuIds),
                'menu_option_id' => $faker->optional()->randomElement($menuOptionIds),
                'quantity' => $faker->numberBetween(1,6),
                'remarks' => $faker->sentence(),
                'completion_status' => $faker->randomElement(['pending','completed','cancelled']),
                'payment_status' => $faker->randomElement(['unpaid','paid']),
            ];

            Transaction::factory()->create($data);
        }
    }
}
