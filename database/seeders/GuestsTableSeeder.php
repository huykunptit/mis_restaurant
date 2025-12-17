<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class GuestsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleId = DB::table('roles')->where('name', 'guest')->value('id');

        $guests = [
            ['first_name' => 'Nguyễn', 'last_name' => 'Văn A', 'email' => 'guest1@example.com'],
            ['first_name' => 'Trần', 'last_name' => 'Thị B', 'email' => 'guest2@example.com'],
            ['first_name' => 'Lê', 'last_name' => 'Minh C', 'email' => 'guest3@example.com'],
        ];

        foreach ($guests as $g) {
            DB::table('users')->insert([
                'first_name' => $g['first_name'],
                'last_name' => $g['last_name'],
                'email' => $g['email'],
                'password' => Hash::make('password'),
                'role_id' => $roleId,
                'remember_token' => null,
            ]);
        }
    }
}
