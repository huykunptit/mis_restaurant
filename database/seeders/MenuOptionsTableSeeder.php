<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuOptionsTableSeeder extends Seeder
{
    public function run()
    {
        $menuId = DB::table('menus')->value('id');

        DB::table('menu_options')->insert([
            ['menu_id' => $menuId, 'name' => 'Nhạt', 'cost' => 0],
            ['menu_id' => $menuId, 'name' => 'Vừa', 'cost' => 1000],
            ['menu_id' => $menuId, 'name' => 'Đậm', 'cost' => 2000],
        ]);
    }
}
