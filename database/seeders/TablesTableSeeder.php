<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Table;

class TablesTableSeeder extends Seeder
{
    public function run()
    {
        // create 25 tables
        Table::factory()->count(25)->create();
    }
}
