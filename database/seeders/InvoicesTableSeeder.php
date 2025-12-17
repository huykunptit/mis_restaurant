<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InvoicesTableSeeder extends Seeder
{
    public function run()
    {
        $userId = DB::table('users')->value('id');
        $storeId = DB::table('stores')->value('id');
        $paymentId = DB::table('payments')->value('id');

        $invoiceId = DB::table('invoices')->insertGetId([
            'user_id' => $userId,
            'store_id' => $storeId,
            'total' => 120000,
            'payment_id' => $paymentId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // create invoice detail for a product
        $productId = DB::table('products')->value('id');
        if ($productId) {
            DB::table('invoice_details')->insert([
                'invoice_id' => $invoiceId,
                'product_id' => $productId,
                'quantity' => 1,
                'price' => 120000,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
