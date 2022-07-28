<?php

namespace Tests\Unit\Brand;

use App\Admin\Exceptions\NotFoundException;
use App\Models\Brand;
use BrandsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * ブランドテスト
 *
 * コマンド実行する場合はプロジェクトのルートディレクトリ上で実行すること
 * $ ./vendor/bin/phpunit ./tests/Unit/Brand/BrandTest.php
 */
class BrandTest extends TestCase
{

    use RefreshDatabase;

    // テスト対象
    private $target;

    public function setUp(): void
    {
        parent::setUp();
        // BrandsSeeder を使用しテストデータを登録
        $this->seed(BrandsSeeder::class);
        $this->target = new Brand();
    }

    /**
     * 概要 ブランド名の重複チェック
     * 条件 ブランド名が重複していない場合
     * 結果 trueを返すこと
     */
    public function test_ブランド名が重複していない場合trueを返すこと()
    {
        $brand = new Brand([
            'name' => 'あいうえお'
        ]);

        /* Lesson02 タスク -初級編- 課題2 */
        // テスト実施
        $actual = $this->target->checkUnique($brand);

        // 検証処理
        $this->assertTrue($actual);
    }

    /**
     * 概要 ブランド名の重複チェック
     * 条件 ブランド名が重複していない場合
     * 結果 falseを返すこと
     */
    public function test_ブランド名が重複する場合falseを返すこと()
    {
        $this->withoutExceptionHandling();
        $brand = new Brand([
            'name' => 'ブランドA'
        ]);

        $actual = $this->target->checkUnique($brand);

        $this->assertFalse($actual);
    }

    /**
     * 概要 ブランド情報の取得
     * 条件 指定したブランドIDに対応するブランド情報が存在しない場合
     * 結果 例外が発生すること
     */
    public function test_ブランド情報が存在しない場合例外が発生すること()
    {

        /* Lesson02 タスク -初級編- 課題3 */
        // 検証処理
        $this->expectException(NotFoundException::class);

        // テスト実行
        $actual = $this->target->findById(0);
    }

    /**
     * ブランド情報の取得処理の検証
     * 条件 テストデータのID1のブランド情報を作成
     * 結果 取得結果が作成したブランド情報と等しいこと
     */
    public function test_ブランド情報の取得処理の検証()
    {
        $brand = new Brand([
            'name' => 'ブランドA',
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
