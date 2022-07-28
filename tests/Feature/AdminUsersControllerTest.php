<?php

namespace Tests\Feature;

use App\Models\AdminPermission;
use App\Models\AdminRole;
use App\Models\AdminRoleUser;
use App\Models\AdminUser;
use App\Models\AdminUserPermission;
use Encore\Admin\Auth\Database\Administrator;
use FeatureTestSetUpSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

/**
 * 管理者コントローラーテスト
 *
 * コマンド実行する場合はプロジェクトのルートディレクトリ上で実行すること
 * $ vendor/bin/phpunit tests/Feature/AdminUsersControllerTest.php
 */
class AdminUsersControllerTest extends TestCase
{
    use RefreshDatabase;

    // ログインに使用する管理者情報
    protected $adminUser;
    // スタブで利用する役割情報
    private $roles;
    // スタブで利用する権限情報
    private $permissions;

    public function setUp(): void
    {
        parent::setUp();
        // Controllerのテスト用のシーダクラスを実行
        $this->seed(FeatureTestSetUpSeeder::class);
        // ファクトリークラスを使用し管理者情報を登録、取得
        $this->adminUser = factory(Administrator::class)->create()->first();
        // 役割と権限情報を紐づける
        factory(AdminUserPermission::class)->create(['user_id' => $this->adminUser->id]);
        factory(AdminRoleUser::class)->create(['user_id' => $this->adminUser->id]);

        // ファクトリークラスを使用し役割・権限情報の生成
        $this->roles = [factory(AdminRole::class)->make()];
        $this->permissions = [factory(AdminPermission::class)->make()];
    }

    /**
     * 管理者一覧画面を正しく表示できた場合のテスト
     */
    public function test_管理者一覧表示画面の検証()
    {
        // スタブの設定
        $this->mock(AdminUser::class, function ($mock) {
            // コントローラ内で利用しているメソッドのモックを作成
            $mock->shouldReceive('getAllRoles')->once()->andReturn($this->roles);
            $mock->shouldReceive('getAllPermissions')->once()->andReturn($this->permissions);
            $mock->shouldReceive('search')->once()->andReturn(new LengthAwarePaginator(null, 1, 1, null));
        });
        // 期待値の設定
        $expectedData = [
            'adminUsers' => new LengthAwarePaginator(null, 1, 1, null),
            'roles' => $this->roles,
            'permissions' => $this->permissions
        ];

        // 認証済ユーザーの指定とhttpメソッドとパスの指定し、実行
        $response = $this->actingAs($this->adminUser, config('admin.auth.guard'))
            ->get(route('admin.adminUsers.index'));
        // 検証
        $response->assertOk()
            ->assertViewIs('admin.admin-users.index')
            ->assertViewHasAll($expectedData);
    }

    /**
     * 管理者詳細画面を正しく表示できた場合のテスト
     */
    public function test_管理者詳細画面の検証()
    {
        // スタブの設定
        $this->mock(AdminUser::class, function ($mock) {
            // コントローラ内で利用しているメソッドのモックを作成
            $mock->shouldReceive('findById')->once()->andReturn($this->adminUser);
        });
        // 期待値の設定
        $expectedData = ['adminUser' => $this->adminUser];

        // 認証済ユーザーの指定とhttpメソッドとパスの指定し、実行
        $response = $this->actingAs($this->adminUser, config('admin.auth.guard'))
            ->get(route('admin.adminUsers.detail', ['id' => $this->adminUser->id]));
        // 検証
        $response->assertOk()
            ->assertViewIs('admin.admin-users.detail')
            ->assertViewHasAll($expectedData);
    }


    /**
     * 管理者新規登録画面を正しく表示できた場合のテスト
     */
    public function test_管理者新規登録画面の検証()
    {
        // スタブの設定
        $this->mock(AdminUser::class, function ($mock) {
            // コントローラ内で利用しているメソッドのモックを作成
            $mock->shouldReceive('getAllRoles')->once()->andReturn($this->roles);
            $mock->shouldReceive('getAllPermissions')->once()->andReturn($this->permissions);
        });
        // 期待値の設定
        $expectedData = [
            'roles' => $this->roles,
            'permissions' => $this->permissions
        ];
        // 認証済ユーザーの指定とhttpメソッドとパスの指定し、実行
        $response = $this->actingAs($this->adminUser, config('admin.auth.guard'))
            ->get(route('admin.adminUsers.createView'));
        // 検証
        $response->assertOk()
            ->assertViewIs('admin.admin-users.create')
            ->assertViewHasAll($expectedData);
    }

    /**
     * 管理者新規登録処理を正しくできた場合のテスト
     */
    public function test_管理者新規登録処理の検証()
    {
        // スタブの設定
        $this->mock(AdminUser::class, function ($mock) {
            // コントローラ内で利用しているメソッドのモックを作成
            $mock->shouldReceive('createAdminUser')->once()->andReturn($this->adminUser);
        });

        // 認証済ユーザーの指定とhttpメソッドとパスの指定し、実行
        $response = $this->actingAs($this->adminUser, config('admin.auth.guard'))
            ->post(route('admin.adminUsers.create'), [
                'userId' => 'dummy',
                'userName' => 'dummy',
                'password' => 'dummy',
                'password_confirmation' => 'dummy',
                'adminUserRoles' => [1],
                'adminUserPermissions' => [1],
            ]);

        // 検証
        $response->assertRedirect(route('admin.adminUsers.detail', ['id' => $this->adminUser->id]));
    }

    /**
     * 管理者編集画面を正しく表示できた場合のテスト
     */
    public function test_管理者編集画面の検証()
    {
        // スタブの設定
        $this->mock(AdminUser::class, function ($mock) {
            // コントローラ内で利用しているメソッドのモックを作成
            $mock->shouldReceive('getAllRoles')->once()->andReturn($this->roles);
            $mock->shouldReceive('getAllPermissions')->once()->andReturn($this->permissions);
            $mock->shouldReceive('findById')->once()->andReturn($this->adminUser);
        });
        // 期待値の設定
        $expectedData = [
            'adminUser' => $this->adminUser,
            'roles' => $this->roles,
            'permissions' => $this->permissions
        ];

        // 認証済ユーザーの指定とhttpメソッドとパスの指定し、実行
        $response = $this->actingAs($this->adminUser, config('admin.auth.guard'))
            ->get(route('admin.adminUsers.editView', ['id' => $this->adminUser->id]));
        // 検証
        $response->assertOk()
            ->assertViewIs('admin.admin-users.edit')
            ->assertViewHasAll($expectedData);
    }

    /**
     * 管理者更新処理を正しくできた場合のテスト
     */
    public function test_管理者更新処理の検証()
    {
        // スタブの設定
        $this->mock(AdminUser::class, function ($mock) {
            // コントローラ内で利用しているメソッドのモックを作成
            $mock->shouldReceive('edit')->once()->andReturn($this->adminUser);
        });

        // 認証済ユーザーの指定とhttpメソッドとパスの指定し、実行
        $response = $this->actingAs($this->adminUser, config('admin.auth.guard'))
            ->post(route('admin.adminUsers.edit', ['id' => $this->adminUser->id]), [
                'userId' => 'dummy',
                'userName' => 'dummy',
                'password' => 'dummy',
                'password_confirmation' => 'dummy',
                'adminUserRoles' => [1],
                'adminUserPermissions' => [1],
            ]);
        // 検証
        $response->assertRedirect(route('admin.adminUsers.detail', ['id' => $this->adminUser->id]));
    }

    /**
     * 管理者削除処理を正しくできた場合のテスト
     */
    public function test_管理者削除処理の検証()
    {
        // スタブの設定
        $this->mock(AdminUser::class, function ($mock) {
            // コントローラ内で利用しているメソッドのモックを作成
            $mock->shouldReceive('deleteById')->once()->andReturn($this->adminUser);
        });

        // 認証済ユーザーの指定とhttpメソッドとパスの指定し、実行
        $response = $this->actingAs($this->adminUser, config('admin.auth.guard'))
            ->delete(route('admin.adminUsers.delete', ['id' => $this->adminUser->id]));
        // 検証
        $response->assertRedirect(route('admin.adminUsers.index'));
    }
}
