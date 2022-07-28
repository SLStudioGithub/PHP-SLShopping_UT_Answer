<?php

namespace Tests\Feature;

use App\Models\AdminRoleUser;
use App\Models\AdminUserPermission;
use App\Models\Item;
use Encore\Admin\Auth\Database\Administrator;
use FeatureTestSetUpSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

/**
 * 商品コントローラーテスト
 *
 * コマンド実行する場合はプロジェクトのルートディレクトリ上で実行すること
 * $ vendor/bin/phpunit tests/Feature/ItemsControllerTest.php
 */
class ItemsControllerTest extends TestCase
{
    use RefreshDatabase;

    // ログインに使用する管理者情報
    protected $adminUser;

    // スタブで利用する商品情報
    private $item;

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

        // ファクトリークラスを使用し商品情報の生成
        $this->item = factory(Item::class)->make();
    }

    /**
     * 商品一覧画面を正しく表示できた場合のテスト
     */
    public function test_商品一覧表示画面の検証()
    {
        // スタブの設定
        $this->mock(Item::class, function ($mock) {
            // コントローラ内で利用しているメソッドのモックを作成
            $mock->shouldReceive('fetchForAdmin')->once()->andReturn(new LengthAwarePaginator(null, 1, 1, null));
        });
        // 期待値の設定
        $expectedData = ['items' => new LengthAwarePaginator(null, 1, 1, null)];

        // 認証済ユーザーの指定とhttpメソッドとパスの指定し、実行
        $response = $this->actingAs($this->adminUser, config('admin.auth.guard'))
            ->get(route('admin.items.index'));
        // 検証
        $response->assertOk()
            ->assertViewIs('admin.items.index')
            ->assertViewHasAll($expectedData);
    }

    /**
     * 商品詳細画面を正しく表示できた場合のテスト
     */
    public function test_商品詳細画面の検証()
    {
        // スタブの設定
        $this->mock(Item::class, function ($mock) {
            // コントローラ内で利用しているメソッドのモックを作成
            $mock->shouldReceive('findById')->once()->andReturn($this->item);
        });
        // 期待値の設定
        $expectedData = ['item' => $this->item];

        // 認証済ユーザーの指定とhttpメソッドとパスの指定し、実行
        $response = $this->actingAs($this->adminUser, config('admin.auth.guard'))
            ->get(route('admin.items.detail', ['id' => $this->item->id]));
        // 検証
        $response->assertOk()
            ->assertViewIs('admin.items.detail')
            ->assertViewHasAll($expectedData);
    }


    /**
     * 商品新規登録画面を正しく表示できた場合のテスト
     * 
     * 静的メソッド（Brand::all()など）のモック化は難易度が高いため不要
     * 新規登録画面に遷移できることをテストする
     */
    public function test_商品新規登録画面の検証()
    {
        // 認証済ユーザーの指定とhttpメソッドとパスの指定し、実行
        $response = $this->actingAs($this->adminUser, config('admin.auth.guard'))
            ->get(route('admin.items.createView'));
        // 検証
        $response->assertOk()
            ->assertViewIs('admin.items.create');
    }

    /**
     * 商品新規登録処理を正しくできた場合のテスト
     */
    public function test_商品新規登録処理の検証()
    {
        // スタブの設定
        $this->mock(Item::class, function ($mock) {
            // コントローラ内で利用しているメソッドのモックを作成
            $mock->shouldReceive('create')->once()->andReturn($this->item);
        });

        // 認証済ユーザーの指定とhttpメソッドとパスの指定し、実行
        $response = $this->actingAs($this->adminUser, config('admin.auth.guard'))
            ->post(route('admin.items.create'), [
                'name' => 'dummy',
                'description' => 'dummy',
                'price' => 1,
                'brandId' => 1,
                'categoryId' => 1,
            ]);

        // 検証
        $response->assertRedirect(route('admin.items.detail', ['id' => $this->item->id]));
    }

    /**
     * 商品編集画面を正しく表示できた場合のテスト
     * 
     * 静的メソッド（Brand::all()など）のモック化は難易度が高いため不要
     * 商品情報をもった状態で、編集画面に遷移できることをテストする
     */
    public function test_商品編集画面の検証()
    {
        // スタブの設定
        $this->mock(Item::class, function ($mock) {
            // コントローラ内で利用しているメソッドのモックを作成
            $mock->shouldReceive('findById')->once()->andReturn($this->item);
        });
        // 期待値の設定
        $expectedData = ['item' => $this->item];

        // 認証済ユーザーの指定とhttpメソッドとパスの指定し、実行
        $response = $this->actingAs($this->adminUser, config('admin.auth.guard'))
            ->get(route('admin.items.editView', ['id' => $this->item->id]));
        // 検証
        $response->assertOk()
            ->assertViewIs('admin.items.edit')
            ->assertViewHasAll($expectedData);
    }

    /**
     * 商品更新処理を正しくできた場合のテスト
     */
    public function test_商品更新処理の検証()
    {
        $this->withoutExceptionHandling();
        // スタブの設定
        $this->mock(Item::class, function ($mock) {
            // コントローラ内で利用しているメソッドのモックを作成
            $mock->shouldReceive('edit')->once()->andReturn($this->item);
        });

        // 認証済ユーザーの指定とhttpメソッドとパスの指定し、実行
        $response = $this->actingAs($this->adminUser, config('admin.auth.guard'))
            ->post(route('admin.items.edit', ['id' => $this->item->id]), [
                'name' => 'dummy',
                'description' => 'dummy',
                'price' => 1,
                'brandId' => 1,
                'categoryId' => 1,
            ]);
        // 検証
        $response->assertRedirect(route('admin.items.detail', ['id' => $this->item->id]));
    }

    /**
     * 商品削除処理を正しくできた場合のテスト
     */
    public function test_商品削除処理の検証()
    {
        // スタブの設定
        $this->mock(Item::class, function ($mock) {
            // コントローラ内で利用しているメソッドのモックを作成
            $mock->shouldReceive('deleteById')->once()->andReturn($this->item);
        });

        // 認証済ユーザーの指定とhttpメソッドとパスの指定し、実行
        $response = $this->actingAs($this->adminUser, config('admin.auth.guard'))
            ->delete(route('admin.items.delete', ['id' => $this->item->id]));
        // 検証
        $response->assertRedirect(route('admin.items.index'));
    }
}
