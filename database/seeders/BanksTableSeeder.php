<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BanksTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('banks')->insert([
            ['name' => 'Vietcombank', 'account_number' => '0123456789', 'account_name' => 'Cong Ty A', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
