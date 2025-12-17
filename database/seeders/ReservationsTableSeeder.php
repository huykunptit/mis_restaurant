<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReservationsTableSeeder extends Seeder
{
    public function run()
    {
        $userId = DB::table('users')->value('id');
        $tableId = DB::table('tables')->value('id');
        $menuId = DB::table('menus')->value('id');
        $menuOptionId = DB::table('menu_options')->value('id');

        DB::table('reservations')->insert([
            'user_id' => $userId,
            'table_id' => $tableId,
            'menu_id' => $menuId,
            'menu_option_id' => $menuOptionId,
            'reservation_time' => now()->addDays(1),
            'status' => 'confirmed',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
