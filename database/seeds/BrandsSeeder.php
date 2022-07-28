<?php

use Illuminate\Database\Seeder;

class BrandsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('brands')->insert([
            [
                'id' => 1,
                'name' => 'ブランドA',
                'created_at' => '2022-07-01 10:00:00',
                'updated_at' => '2022-07-01 10:00:00',
            ],
            [
                'id' => 2,
                'name' => 'ブランドB',
                'created_at' => '2022-07-01 10:00:00',
                'updated_at' => '2022-07-01 10:00:00',
            ],
            [
                'id' => 3,
                'name' => 'ブランドC',
                'created_at' => '2022-07-01 10:00:00',
                'updated_at' => '2022-07-01 10:00:00',
            ],
        ]);
    }
}
