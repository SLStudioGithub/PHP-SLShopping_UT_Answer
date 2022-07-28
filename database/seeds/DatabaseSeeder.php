<?php

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
            AdminTablesSeeder::class,
            BrandsSeeder::class,
            CategoriesSeeder::class,
            ItemsSeeder::class,
        ]);
    }
}
