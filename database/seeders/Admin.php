<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
class Admin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRoleId = DB::table('roles')->where('name', 'admin')->value('id');

        DB::table('users')->insert([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@ptit.com',
            'password' => Hash::make('Demo@1234'), 
            'role_id' => $adminRoleId,
            'remember_token' => null,
        ]);
    }
}
