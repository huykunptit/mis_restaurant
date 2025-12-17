<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RolesTableSeeder::class,
            Admin::class,
            GuestsTableSeeder::class,
            EmployeesTableSeeder::class,
            StoresTableSeeder::class,
            CategoriesTableSeeder::class,
            MenusTableSeeder::class,
            MenuOptionsTableSeeder::class,
            ProductsTableSeeder::class,
            BanksTableSeeder::class,
            PaymentsTableSeeder::class,
            TablesTableSeeder::class,
            ReservationsTableSeeder::class,
            TemporaryOrdersTableSeeder::class,
            TransactionsTableSeeder::class,
            InvoicesTableSeeder::class,
        ]);
    }
}
