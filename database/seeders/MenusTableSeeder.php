<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Menu;
use App\Models\Category;

class MenusTableSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create();

        $categories = Category::all();

        // Vietnamese dish names per category
        $dishes = [
            'Khai vị' => ['Gỏi cuốn', 'Nem rán', 'Chả giò', 'Bánh gối', 'Xoài trộn tép'],
            'Món chính' => ['Phở bò', 'Bún chả', 'Cơm tấm sườn', 'Bò lúc lắc', 'Cá kho tộ', 'Gà nướng', 'Lẩu hải sản'],
            'Canh & Cháo' => ['Canh chua cá', 'Canh rau muống', 'Cháo gà', 'Canh bí đỏ'],
            'Gỏi & Salad' => ['Gỏi gà', 'Gỏi đu đủ', 'Salad cá ngừ'],
            'Tráng miệng' => ['Chè thập cẩm', 'Bánh flan', 'Kem trái cây'],
            'Đồ uống' => ['Trà đá', 'Nước mía', 'Trà sữa', 'Nước chanh', 'Cà phê sữa đá'],
        ];

        foreach ($categories as $category) {
            $names = $dishes[$category->name] ?? [$faker->word() . ' đặc biệt'];
            // create between 4-8 items per category, but cap total roughly
            $count = rand(4, min(8, max(4, count($names))));

            for ($i = 0; $i < $count; $i++) {
                $name = $names[$i % count($names)];
                Menu::factory()->create([
                    'name' => $name,
                    'category_id' => $category->id,
                    'disable' => $faker->randomElement(['no','yes']),
                    'thumbnail' => null,
                ]);
            }
        }
    }
}
