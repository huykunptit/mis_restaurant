<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TemporaryOrdersTableSeeder extends Seeder
{
    public function run()
    {
        $userId = DB::table('users')->value('id');
        $menuId = DB::table('menus')->value('id');
        $menuOptionId = DB::table('menu_options')->value('id');

        DB::table('temporary_orders')->insert([
            'user_id' => $userId,
            'menu_id' => $menuId,
            'menu_option_id' => $menuOptionId,
            'quantity' => 2,
            'remarks' => 'Giao nhanh',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
