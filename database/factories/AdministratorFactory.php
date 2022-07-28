<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Encore\Admin\Auth\Database\Administrator;
use Faker\Generator as Faker;

$factory->define(Administrator::class, function (Faker $faker) {
    return [
        'name' => 'ut',
        'username' => 'ut@example.com',
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
    ];
});
