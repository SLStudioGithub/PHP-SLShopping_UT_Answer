<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Brand;
use App\Models\Category;
use App\Models\Item;
use Faker\Generator as Faker;

$factory->define(Item::class, function (Faker $faker) {
    return [
        'id' => 1,
        'name' => 'ダミーデータ',
        'description' => $faker->unique()->realText(50),
        'price' => 1000,
        'brand_id' => factory(Brand::class),
        'category_id' => factory(Category::class),
    ];
});
