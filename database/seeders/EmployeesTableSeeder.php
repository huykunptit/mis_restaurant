<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleId = DB::table('roles')->where('name', 'employee')->value('id');

        $employees = [
            ['first_name' => 'Phạm', 'last_name' => 'Văn Hùng', 'email' => 'emp1@example.com'],
            ['first_name' => 'Hoàng', 'last_name' => 'Thị Lan', 'email' => 'emp2@example.com'],
            ['first_name' => 'Đỗ', 'last_name' => 'Minh Tuấn', 'email' => 'emp3@example.com'],
        ];

        foreach ($employees as $e) {
            DB::table('users')->insert([
                'first_name' => $e['first_name'],
                'last_name' => $e['last_name'],
                'email' => $e['email'],
                'password' => Hash::make('Password@123'),
                'role_id' => $roleId,
                'remember_token' => null,
            ]);
        }
    }
}
