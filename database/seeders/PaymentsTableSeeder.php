<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentsTableSeeder extends Seeder
{
    public function run()
    {
        $bankId = DB::table('banks')->value('id');
        DB::table('payments')->insert([
            ['method' => 'cash', 'bank_id' => null, 'created_at' => now(), 'updated_at' => now()],
            ['method' => 'bank_transfer', 'bank_id' => $bankId, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
