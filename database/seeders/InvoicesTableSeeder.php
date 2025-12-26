<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InvoicesTableSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create();
        $userIds = DB::table('users')->pluck('id')->toArray();
        $productIds = DB::table('products')->pluck('id')->toArray();
        $paymentIds = DB::table('payments')->pluck('id')->toArray();
        $storeId = DB::table('stores')->value('id');

        for ($i=0;$i<30;$i++){
            $userId = $faker->randomElement($userIds);
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
    }
}
