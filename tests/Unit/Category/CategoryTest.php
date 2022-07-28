<?php

namespace Tests\Unit\Category;

use App\Admin\Exceptions\NotFoundException;
use App\Models\Category;
use CategoriesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * カテゴリーテスト
 *
 * コマンド実行する場合はプロジェクトのルートディレクトリ上で実行すること
 * $ ./vendor/bin/phpunit ./tests/Unit/Category/CategoryTest.php
 */
class CategoryTest extends TestCase
{

    use RefreshDatabase;

    // テスト対象
    private $target;

    public function setUp(): void
    {
        parent::setUp();
        // CategoriesSeeder を使用しテストデータを登録
        $this->seed(CategoriesSeeder::class);
        $this->target = new Category();
    }

    /**
     * 概要 カテゴリー名の重複チェック
     * 条件 カテゴリー名が重複していない場合
     * 結果 trueを返すこと
     */
    public function test_カテゴリー名が重複していない場合trueを返すこと()
    {
        $brand = new Category([
            'name' => 'あいうえお'
        ]);
        $actual = $this->target->checkUnique($brand);

        $this->assertTrue($actual);
    }

    /**
     * 概要 カテゴリー名の重複チェック
     * 条件 カテゴリー名が重複していない場合
     * 結果 falseを返すこと
     */
    public function test_カテゴリー名が重複する場合falseを返すこと()
    {
        $brand = new Category([
            'name' => 'カテゴリーA'
        ]);
        $actual = $this->target->checkUnique($brand);

        $this->assertFalse($actual);
    }

    /**
     * 概要 カテゴリー情報の取得
     * 条件 指定したカテゴリーIDに対応するカテゴリー情報が存在しない場合
     * 結果 例外が発生すること
     */
    public function test_カテゴリー情報が存在しない場合例外が発生すること()
    {
        $this->expectException(NotFoundException::class);
        $actual = $this->target->findById(0);
    }

    /**
     * カテゴリー情報の取得処理の検証
     * 条件 テストデータのID1のカテゴリー情報を作成
     * 結果 取得結果が作成したカテゴリー情報と等しいこと
     */
    public function test_カテゴリー情報の取得処理の検証()
    {
        $brand = new Category([
            'name' => 'カテゴリーA'
        ]);
        $brand->id = 1;
        $brand->created_at = '2022-07-01 10:00:00';
        $brand->updated_at = '2022-07-01 10:00:00';
        $brand->deleted_at = null;
        $expected = $brand->toArray();

        $actual = $this->target->findById(1)->toArray();

        $this->assertEquals($expected, $actual);
    }
}
