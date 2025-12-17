<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        $storeId = DB::table('stores')->value('id');

        DB::table('products')->insert([
            ['name' => 'Phở Bò (S)', 'price' => 50000, 'stock' => 10, 'store_id' => $storeId, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Phở Bò (L)', 'price' => 70000, 'stock' => 5, 'store_id' => $storeId, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
