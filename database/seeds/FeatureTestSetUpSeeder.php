<?php

use App\Models\AdminPermission;
use App\Models\AdminRole;
use App\Models\AdminUser;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Image;
use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\ItemDetail;
use App\Models\ItemImage;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * PHPUnit で Feature テスト毎に実行する初期化用シーダー
 */
class FeatureTestSetUpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AdminRole::truncate();
        AdminRole::insert([
            'name' => 'Administrator',
            'slug' => 'administrator',
        ]);

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
        Item::truncate();
        Brand::truncate();
        Category::truncate();
    }
}
