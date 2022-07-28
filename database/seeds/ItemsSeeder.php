<?php

use Illuminate\Database\Seeder;

class ItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('items')->insert([
            [
                'id' => 1,
                'name' => '商品A',
                'description' => '商品の説明',
                'price' => 200000,
                'brand_id' => 1,
                'category_id' => 1,
                'created_at' => '2022-07-01 10:00:00',
                'updated_at' => '2022-07-01 10:00:00',
            ],
            [
                'id' => 2,
                'name' => '商品B',
                'description' => '商品の説明',
                'price' => 150000,
                'brand_id' => 1,
                'category_id' => 1,
                'created_at' => '2022-07-01 10:00:00',
                'updated_at' => '2022-07-01 10:00:00',
            ],
            [
                'id' => 3,
                'name' => '商品C',
                'description' => '商品の説明',
                'price' => 50000,
                'brand_id' => 1,
                'category_id' => 1,
                'created_at' => '2022-07-01 10:00:00',
                'updated_at' => '2022-07-01 10:00:00',
            ],
        ]);
    }
}
