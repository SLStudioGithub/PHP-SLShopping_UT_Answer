<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\AdminRole;

$factory->define(AdminRole::class, function () {
    return [
        'id' => 1,
        'name' => 'Administrator',
        'slug' => 'administrator',
    ];
});