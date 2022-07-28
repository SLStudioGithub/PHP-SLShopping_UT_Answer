<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\AdminRoleUser;

$factory->define(AdminRoleUser::class, function () {
    return [
        'role_id' => 1,
        'user_id' => 1,
    ];
});
