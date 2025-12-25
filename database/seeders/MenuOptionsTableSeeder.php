<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Menu;
use App\Models\MenuOption;
use Faker\Factory as Faker;

class MenuOptionsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $menus = Menu::all();

        foreach ($menus as $menu) {
            $count = rand(1,3);
            // determine price band by category
            $cat = optional($menu->category)->name;
            if ($cat === 'Đồ uống') {
                $min = 8000; $max = 50000;
                $optionNames = ['Nhỏ','Lớn','Bình thường','Không đường','Có đường'];
            } elseif ($cat === 'Khai vị' || $cat === 'Tráng miệng' || $cat === 'Gỏi & Salad') {
                $min = 15000; $max = 80000;
                $optionNames = ['Thường','Phần nhỏ','Phần lớn'];
            } elseif ($cat === 'Canh & Cháo') {
                $min = 20000; $max = 90000;
                $optionNames = ['Bát thường','Bát lớn'];
            } else { // Món chính
                $min = 40000; $max = 250000;
                $optionNames = ['Phần thường','Phần gia đình','Phần suất'];
            }

            for ($i=0;$i<$count;$i++){
                MenuOption::factory()->create([
                    'menu_id' => $menu->id,
                    'name' => $faker->randomElement($optionNames),
                    'cost' => $faker->numberBetween($min,$max),
                ]);
            }
        }
    }
}
