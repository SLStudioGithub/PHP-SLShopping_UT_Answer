<?php

namespace Tests\Feature;

use App\Models\AdminRoleUser;
use App\Models\AdminUserPermission;
use App\Models\Brand;
use Encore\Admin\Auth\Database\Administrator;
use FeatureTestSetUpSeeder;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

/**
 * ブランドコントローラーテスト
 *
 * コマンド実行する場合はプロジェクトのルートディレクトリ上で実行すること
 * $ vendor/bin/phpunit tests/Feature/BrandsControllerTest.php
 */
class BrandsControllerTest extends TestCase
{
    // ログインに使用する管理者情報
    protected $adminUser;

    // スタブで利用するブランド情報
    private $brand;

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

        // ファクトリークラスを使用しブランド情報の生成
        $this->brand = factory(Brand::class)->make();
    }

    /**
     * ブランド一覧画面を正しく表示できた場合のテスト
     */
    public function test_ブランド一覧表示画面の検証()
    {
        // スタブの設定
        $this->mock(Brand::class, function ($mock) {
            // コントローラ内で利用しているメソッドのモックを作成
            $mock->shouldReceive('fetch')->once()->andReturn(new LengthAwarePaginator(null, 1, 1, null));
        });
        // 期待値の設定(スタブで設定したデータ)
        $expectedData = ['brands' => new LengthAwarePaginator(null, 1, 1, null)];

        // 認証済ユーザーの指定とhttpメソッドとパスの指定し、実行
        $response = $this->actingAs($this->adminUser, config('admin.auth.guard'))
            ->get(route('admin.brands.index'));
        // 検証
        $response->assertOk()
            ->assertViewIs('admin.brands.index') // 表示するBladeファイル
            ->assertViewHasAll($expectedData); // Viewで使うデータ
    }

    /**
     * ブランド詳細画面を正しく表示できた場合のテスト
     */
    public function test_ブランド詳細画面の検証()
    {
        // スタブの設定
        $this->mock(Brand::class, function ($mock) {
            // コントローラ内で利用しているメソッドのモックを作成
            $mock->shouldReceive('findById')->once()->andReturn($this->brand);
        });
        // 期待値の設定
        $expectedData = ['brand' => $this->brand];

        // 認証済ユーザーの指定とhttpメソッドとパスの指定し、実行
        $response = $this->actingAs($this->adminUser, config('admin.auth.guard'))
            ->get(route('admin.brands.detail', ['id' => $this->brand->id]));
        // 検証
        $response->assertOk()
            ->assertViewIs('admin.brands.detail')
            ->assertViewHasAll($expectedData);
    }


    /**
     * ブランド新規登録画面を正しく表示できた場合のテスト
     */
    public function test_ブランド新規登録画面の検証()
    {
        // 認証済ユーザーの指定とhttpメソッドとパスの指定し、実行
        $response = $this->actingAs($this->adminUser, config('admin.auth.guard'))
            ->get(route('admin.brands.createView'));
        // 検証
        $response->assertOk()
            ->assertViewIs('admin.brands.create');
    }

    /**
     * ブランド新規登録処理を正しくできた場合のテスト
     */
    public function test_ブランド新規登録処理の検証()
    {
        // スタブの設定
        $this->mock(Brand::class, function ($mock) {
            // コントローラ内で利用しているメソッドのモックを作成
            $mock->shouldReceive('create')->once()->andReturn($this->brand);
        });

        // 認証済ユーザーの指定とhttpメソッドとパスの指定し、実行
        $response = $this->actingAs($this->adminUser, config('admin.auth.guard'))
            ->post(route('admin.brands.create'), [
                'name' => 'dummy' // form でブランド名を送信する
            ]);

        // 検証
        $response->assertRedirect(route('admin.brands.detail', ['id' => $this->brand->id]));
    }

    /**
     * ブランド編集画面を正しく表示できた場合のテスト
     *
     * @return void
     */
    public function test_ブランド編集画面の検証()
    {
        // スタブの設定
        $this->mock(Brand::class, function ($mock) {
            // コントローラ内で利用しているメソッドのモックを作成
            $mock->shouldReceive('findById')->once()->andReturn($this->brand);
        });
        // 期待値の設定
        $expectedData = ['brand' => $this->brand];

        // 認証済ユーザーの指定とhttpメソッドとパスの指定し、実行
        $response = $this->actingAs($this->adminUser, config('admin.auth.guard'))
            ->get(route('admin.brands.editView', ['id' => $this->brand->id]));
        // 検証
        $response->assertOk()
            ->assertViewIs('admin.brands.edit')
            ->assertViewHasAll($expectedData);
    }

    /**
     * ブランド更新処理を正しくできた場合のテスト
     */
    public function test_ブランド更新処理の検証()
    {
        // スタブの設定
        $this->mock(Brand::class, function ($mock) {
            // コントローラ内で利用しているメソッドのモックを作成
            $mock->shouldReceive('edit')->once()->andReturn($this->brand);
        });

        // 認証済ユーザーの指定とhttpメソッドとパスの指定し、実行
        $response = $this->actingAs($this->adminUser, config('admin.auth.guard'))
            ->post(route('admin.brands.edit', ['id' => $this->brand->id]), [
                'name' => 'dummy'
            ]);
        // 検証
        $response->assertRedirect(route('admin.brands.detail', ['id' => $this->brand->id]));
    }

    /**
     * ブランド削除処理を正しくできた場合のテスト
     */
    public function test_ブランド削除処理の検証()
    {
        // スタブの設定
        $this->mock(Brand::class, function ($mock) {
            // コントローラ内で利用しているメソッドのモックを作成
            $mock->shouldReceive('deleteById')->once()->andReturn($this->brand);
        });

        // 認証済ユーザーの指定とhttpメソッドとパスの指定し、実行
        $response = $this->actingAs($this->adminUser, config('admin.auth.guard'))
            ->delete(route('admin.brands.delete', ['id' => $this->brand->id]));
        // 検証
        $response->assertRedirect(route('admin.brands.index'));
    }
}
