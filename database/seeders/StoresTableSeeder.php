<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StoresTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('stores')->insert([
            ['name' => 'Cửa hàng A', 'address' => 'Hà Nội', 'phone' => '0123456789', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Cửa hàng B', 'address' => 'Hồ Chí Minh', 'phone' => '0987654321', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
