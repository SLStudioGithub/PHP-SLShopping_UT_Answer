<?php

use App\Models\AdminPermission;
use App\Models\AdminRole;
use App\Models\AdminRoleUser;
use App\Models\AdminUser;
use App\Models\AdminUserPermission;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AdminTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // create a role.
        AdminRole::truncate();
        AdminRole::create([
            'name' => 'Administrator',
            'slug' => 'administrator',
        ]);

        //create a permission
        AdminPermission::truncate();
        AdminPermission::insert([
            [
                'name'        => 'All permission',
                'slug'        => '*',
                'http_method' => '',
                'http_path'   => '*',
            ],
        ]);

        AdminUser::truncate();
        AdminUser::insert([
            [
                'id' => 1,
                'name' => '管理者A',
                'username' => 'admin@example.com',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'created_at' => '2022-07-01 10:00:00',
                'updated_at' => '2022-07-01 10:00:00',
            ],
        ]);

        AdminRoleUser::truncate();
        AdminRoleUser::insert([
            [
                'role_id' => 1,
                'user_id' => 1,
            ],
        ]);

        AdminUserPermission::truncate();
        AdminUserPermission::insert([
            [
                'user_id' => 1,
                'permission_id' => 1,
            ],
        ]);
    }
}
