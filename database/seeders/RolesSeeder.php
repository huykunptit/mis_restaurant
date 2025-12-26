<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insertOrIgnore([
            ['id' => 1, 'name' => 'admin', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'user', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'employee', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'customer', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'guest', 'created_at' => now(), 'updated_at' => now()],
        ]);

        $this->command->info('Roles seeded successfully.');
    }
}

