<?php

namespace Tests\Feature;

use App\Models\AdminRoleUser;
use App\Models\AdminUserPermission;
use App\Models\Category;
use Encore\Admin\Auth\Database\Administrator;
use FeatureTestSetUpSeeder;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

/**
 * カテゴリーコントローラーテスト
 *
 * コマンド実行する場合はプロジェクトのルートディレクトリ上で実行すること
 * $ vendor/bin/phpunit tests/Feature/CategoriesControllerTest.php
 */
class CategoriesControllerTest extends TestCase
{
    // ログインに使用する管理者情報
    protected $adminUser;

    // スタブで利用するカテゴリー情報
    private $category;

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

        // ファクトリークラスを使用しカテゴリー情報の生成
        $this->category = factory(Category::class)->make();
    }

    /**
     * カテゴリー一覧画面を正しく表示できた場合のテスト
     */
    public function test_カテゴリー一覧表示画面の検証()
    {
        // スタブの設定
        $this->mock(Category::class, function ($mock) {
            // コントローラ内で利用しているメソッドのモックを作成
            $mock->shouldReceive('fetch')->once()->andReturn(new LengthAwarePaginator(null, 1, 1, null));
        });
        // 期待値の設定
        $expectedData = ['categories' => new LengthAwarePaginator(null, 1, 1, null)];

        // 認証済ユーザーの指定とhttpメソッドとパスの指定し、実行
        $response = $this->actingAs($this->adminUser, config('admin.auth.guard'))
            ->get(route('admin.categories.index'));
        // 検証
        $response->assertOk()
            ->assertViewIs('admin.categories.index')
            ->assertViewHasAll($expectedData);
    }

    /**
     * カテゴリー詳細画面を正しく表示できた場合のテスト
     */
    public function test_カテゴリー詳細画面の検証()
    {
        // スタブの設定
        $this->mock(Category::class, function ($mock) {
            // コントローラ内で利用しているメソッドのモックを作成
            $mock->shouldReceive('findById')->once()->andReturn($this->category);
        });
        // 期待値の設定
        $expectedData = ['category' => $this->category];

        // 認証済ユーザーの指定とhttpメソッドとパスの指定し、実行
        $response = $this->actingAs($this->adminUser, config('admin.auth.guard'))
            ->get(route('admin.categories.detail', ['id' => $this->category->id]));
        // 検証
        $response->assertOk()
            ->assertViewIs('admin.categories.detail')
            ->assertViewHasAll($expectedData);
    }


    /**
     * カテゴリー新規登録画面を正しく表示できた場合のテスト
     */
    public function test_カテゴリー新規登録画面の検証()
    {
        // 認証済ユーザーの指定とhttpメソッドとパスの指定し、実行
        $response = $this->actingAs($this->adminUser, config('admin.auth.guard'))
            ->get(route('admin.categories.createView'));
        // 検証
        $response->assertOk()
            ->assertViewIs('admin.categories.create');
    }

    /**
     * カテゴリー新規登録処理を正しくできた場合のテスト
     */
    public function test_カテゴリー新規登録処理の検証()
    {
        // スタブの設定
        $this->mock(Category::class, function ($mock) {
            // コントローラ内で利用しているメソッドのモックを作成
            $mock->shouldReceive('create')->once()->andReturn($this->category);
        });

        // 認証済ユーザーの指定とhttpメソッドとパスの指定し、実行
        $response = $this->actingAs($this->adminUser, config('admin.auth.guard'))
            ->post(route('admin.categories.create'), [
                'name' => 'dummy' // form でカテゴリー名を送信する
            ]);

        // 検証
        $response->assertRedirect(route('admin.categories.detail', ['id' => $this->category->id]));
    }

    /**
     * カテゴリー編集画面を正しく表示できた場合のテスト
     *
     * @return void
     */
    public function test_カテゴリー編集画面の検証()
    {
        // スタブの設定
        $this->mock(Category::class, function ($mock) {
            // コントローラ内で利用しているメソッドのモックを作成
            $mock->shouldReceive('findById')->once()->andReturn($this->category);
        });
        // 期待値の設定
        $expectedData = ['category' => $this->category];

        // 認証済ユーザーの指定とhttpメソッドとパスの指定し、実行
        $response = $this->actingAs($this->adminUser, config('admin.auth.guard'))
            ->get(route('admin.categories.editView', ['id' => $this->category->id]));
        // 検証
        $response->assertOk()
            ->assertViewIs('admin.categories.edit')
            ->assertViewHasAll($expectedData);
    }

    /**
     * カテゴリー更新処理を正しくできた場合のテスト
     */
    public function test_カテゴリー更新処理の検証()
    {
        // スタブの設定
        $this->mock(Category::class, function ($mock) {
            // コントローラ内で利用しているメソッドのモックを作成
            $mock->shouldReceive('edit')->once()->andReturn($this->category);
        });

        // 認証済ユーザーの指定とhttpメソッドとパスの指定し、実行
        $response = $this->actingAs($this->adminUser, config('admin.auth.guard'))
            ->post(route('admin.categories.edit', ['id' => $this->category->id]), [
                'name' => 'dummy'
            ]);
        // 検証
        $response->assertRedirect(route('admin.categories.detail', ['id' => $this->category->id]));
    }

    /**
     * カテゴリー削除処理を正しくできた場合のテスト
     */
    public function test_カテゴリー削除処理の検証()
    {
        // スタブの設定
        $this->mock(Category::class, function ($mock) {
            // コントローラ内で利用しているメソッドのモックを作成
            $mock->shouldReceive('deleteById')->once()->andReturn($this->category);
        });

        // 認証済ユーザーの指定とhttpメソッドとパスの指定し、実行
        $response = $this->actingAs($this->adminUser, config('admin.auth.guard'))
            ->delete(route('admin.categories.delete', ['id' => $this->category->id]));
        // 検証
        $response->assertRedirect(route('admin.categories.index'));
    }
}
