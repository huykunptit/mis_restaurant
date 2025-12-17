<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TablesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('tables')->insert([
            ['table_number' => 'A1', 'status' => 'available', 'seats' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['table_number' => 'A2', 'status' => 'available', 'seats' => 2, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
