<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionsTableSeeder extends Seeder
{
    public function run()
    {
        $userId = DB::table('users')->value('id');
        $menuId = DB::table('menus')->value('id');
        $menuOptionId = DB::table('menu_options')->value('id');

        DB::table('transactions')->insert([
            'user_id' => $userId,
            'menu_id' => $menuId,
            'menu_option_id' => $menuOptionId,
            'quantity' => 1,
            'remarks' => 'Ăn tại chỗ',
            'completion_status' => 'pending',
            'payment_status' => 'unpaid',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
