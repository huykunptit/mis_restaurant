<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Table;

class SimpleDataSeeder extends Seeder
{
    public function run()
    {
        // Clear existing tables data
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Table::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Create 25 tables with proper schema
        for ($i = 1; $i <= 25; $i++) {
            Table::create([
                'code' => 'T' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'table_number' => 'BT' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'seats' => [2, 4, 6, 8, 10][array_rand([2, 4, 6, 8, 10])],
                'status' => ['available', 'occupied', 'reserved'][array_rand(['available', 'occupied', 'reserved'])],
            ]);
        }

        $this->command->info('✅ SimpleDataSeeder completed!');
        $this->command->info('   - Created 25 tables');
    }
}
