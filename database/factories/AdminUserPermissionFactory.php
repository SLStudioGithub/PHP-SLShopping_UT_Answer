<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\AdminUserPermission;

$factory->define(AdminUserPermission::class, function () {
    return [
        'user_id' => 1,
        'permission_id' => 1,
    ];
});
