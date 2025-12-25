<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('categories')->insert([
            ['name' => 'Khai vị'],
            ['name' => 'Món chính'],
            ['name' => 'Canh & Cháo'],
            ['name' => 'Gỏi & Salad'],
            ['name' => 'Tráng miệng'],
            ['name' => 'Đồ uống'],
        ]);
    }
}
