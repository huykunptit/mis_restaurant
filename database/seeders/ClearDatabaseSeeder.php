<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ClearDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * XÓA TẤT CẢ DỮ LIỆU (trừ users, roles, categories, menus, menu_options, tables)
     */
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Xóa dữ liệu từ các bảng liên quan đến orders/transactions
        DB::table('transactions')->truncate();
        DB::table('temporary_orders')->truncate();
        DB::table('reservations')->truncate();
        DB::table('payments')->truncate();
        DB::table('notifications')->truncate();

        // Reset table status về available
        DB::table('tables')->update([
            'status' => 'available',
            'is_merged' => 0,
            'merged_from' => null,
        ]);

        // Enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info('✅ Đã xóa tất cả dữ liệu orders, transactions, reservations, payments, notifications');
        $this->command->info('✅ Đã reset tất cả bàn về trạng thái "available"');
        $this->command->info('ℹ️  Giữ nguyên: users, roles, categories, menus, menu_options, tables');
    }
}

