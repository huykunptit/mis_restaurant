<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Category;
use App\Models\Menu;
use App\Models\MenuOption;
use App\Models\Table;
use App\Models\TemporaryOrder;
use App\Models\Transaction;
use App\Models\Reservation;

class DemoLargeSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create();

        // Users (customers/employees) - create 25
        $users = User::factory()->count(25)->create();

        // Categories - create 20
        $categories = Category::factory()->count(20)->create();

        // Menus (products) - create 30 and attach to categories
        $menus = collect();
        for ($i = 0; $i < 30; $i++) {
            $menu = Menu::factory()->make();
            $menu->category_id = $categories->random()->id;
            $menu->save();
            $menus->push($menu);

            // create 1-3 options per menu
            $opts = MenuOption::factory()->count(rand(1,3))->make()->each(function($opt) use ($menu){
                $opt->menu_id = $menu->id;
                $opt->save();
            });
        }

        // Tables - create 25
        $tables = Table::factory()->count(25)->create();

        // Temporary Orders - create 60
        for ($i=0; $i<60; $i++){
            $menu = $menus->random();
            $option = MenuOption::where('menu_id', $menu->id)->inRandomOrder()->first();
            TemporaryOrder::factory()->create([
                'user_id' => $users->random()->id,
                'menu_id' => $menu->id,
                'menu_option_id' => $option->id ?? null,
            ]);
        }

        // Transactions (orders) - create 120
        for ($i=0; $i<120; $i++){
            $menu = $menus->random();
            $option = MenuOption::where('menu_id', $menu->id)->inRandomOrder()->first();
            $tx = Transaction::factory()->make([
                'user_id' => $users->random()->id,
                'menu_id' => $menu->id,
                'menu_option_id' => $option->id ?? null,
                'table_id' => $tables->random()->id,
            ]);
            // set payment_status based on completion
            if ($tx->completion_status === 'completed') {
                $tx->payment_status = 'paid';
            }
            $tx->save();
        }

        // Reservations - create 30
        for ($i=0; $i<30; $i++){
            $menu = $menus->random();
            $option = MenuOption::where('menu_id', $menu->id)->inRandomOrder()->first();
            Reservation::factory()->create([
                'user_id' => $users->random()->id,
                'table_id' => $tables->random()->id,
                'menu_id' => $menu->id,
                'menu_option_id' => $option->id ?? null,
                'reservation_time' => $faker->dateTimeBetween('+1 days', '+30 days'),
            ]);
        }

        // Invoices: create 40 invoices using existing products table
        $productIds = DB::table('products')->pluck('id')->toArray();
        $paymentIds = DB::table('payments')->pluck('id')->toArray();
        $storeId = DB::table('stores')->value('id');

        for ($i=0; $i<40; $i++){
            $userId = $users->random()->id;
            $paymentId = $paymentIds ? $faker->randomElement($paymentIds) : null;
            $productId = $productIds ? $faker->randomElement($productIds) : null;
            $qty = $productId ? $faker->numberBetween(1,5) : 0;
            $price = $productId ? DB::table('products')->where('id',$productId)->value('price') : 0;
            $total = $price * $qty;

            $invoiceId = DB::table('invoices')->insertGetId([
                'user_id' => $userId,
                'store_id' => $storeId,
                'total' => $total,
                'payment_id' => $paymentId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            if ($productId) {
                DB::table('invoice_details')->insert([
                    'invoice_id' => $invoiceId,
                    'product_id' => $productId,
                    'quantity' => $qty,
                    'price' => $price,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Done
    }
}
