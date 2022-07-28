<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\AdminPermission;

$factory->define(AdminPermission::class, function () {
    return [
        'id' => 1,
        'name' => 'All permission',
        'slug' => '*',
        'http_method' => '',
        'http_path' => '*',
    ];
});
