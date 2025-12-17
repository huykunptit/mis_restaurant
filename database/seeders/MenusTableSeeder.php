<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenusTableSeeder extends Seeder
{
    public function run()
    {
        $categoryId = DB::table('categories')->value('id');
        $storeId = DB::table('stores')->value('id');

        $menuId = DB::table('menus')->insertGetId([
            'name' => 'Phở Bò',
            'category_id' => $categoryId,
            'disable' => '0',
            'thumbnail' => null,
        ]);

        // create a second menu
        DB::table('menus')->insert([
            'name' => 'Trà Đá',
            'category_id' => $categoryId,
            'disable' => '0',
            'thumbnail' => null,
        ]);
    }
}
