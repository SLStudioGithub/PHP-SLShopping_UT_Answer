<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            [
                'id' => 1,
                'name' => 'カテゴリーA',
                'created_at' => '2022-07-01 10:00:00',
                'updated_at' => '2022-07-01 10:00:00',
            ],
            [
                'id' => 2,
                'name' => 'カテゴリーB',
                'created_at' => '2022-07-01 10:00:00',
                'updated_at' => '2022-07-01 10:00:00',
            ],
            [
                'id' => 3,
                'name' => 'カテゴリーC',
                'created_at' => '2022-07-01 10:00:00',
                'updated_at' => '2022-07-01 10:00:00',
            ],
        ]);
    }
}
