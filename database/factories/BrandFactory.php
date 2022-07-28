<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Brand;
use Encore\Admin\Form\Field\Id;
use Faker\Generator as Faker;

$factory->define(Brand::class, function () {
    return [
        'id' => 1,
        'name' => 'ダミーデータ'
    ];
});
