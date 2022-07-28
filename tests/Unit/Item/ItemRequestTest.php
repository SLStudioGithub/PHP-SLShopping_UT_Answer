<?php

namespace Tests\Unit\Brand;

use App\Admin\Requests\ItemRequest;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

/**
 * 商品リクエストテスト
 *
 * コマンド実行する場合はプロジェクトのルートディレクトリ上で実行すること
 * $ ./vendor/bin/phpunit ./tests/Unit/Item/ItemRequestTest.php
 */
class ItemRequestTest extends TestCase
{

    /**
     * 概要 商品名・商品説明のパラメーター化テスト
     * 条件 データプロバイダメソッドのラベル
     * 結果 条件に応じた結果(true, false)を返すこと
     * 
     * @dataProvider validationDataProvider
     */
    public function test_パラメーター化テスト($param, $expected)
    {
        $request = new ItemRequest();
        $rules = $request->rules();
        $validator = Validator::make($param, $rules);
        // テスト実施
        $actual = $validator->passes();

        // 検証
        $this->assertSame($expected, $actual);        
    }
    // データプロバイダメソッド
    public function validationDataProvider(): array
    {
        // 'ラベル' => [パラメータ, 期待値]
        return [
            '商品名が1文字かつ商品説明が1文字の場合' => [
                [
                    'name' => 'あ',
                    'description' => 'あ',
                ],
                true
            ],
            '商品名が10文字かつ商品説明が50文字の場合' => [
                [
                    'name' => 'ああああああああああ',
                    'description' => 'ああああああああああいいいいいいいいいいううううううううううええええええええええおおおおおおおおおお',
                ],
                true
            ],
            '商品名が10文字かつ商品説明が1文字の場合' => [
                [
                    'name' => 'ああああああああああ',
                    'description' => 'あ',
                ],
                true
            ],
            '商品名が1文字かつ商品説明が50文字の場合' => [
                [
                    'name' => 'あ',
                    'description' => 'ああああああああああいいいいいいいいいいううううううううううええええええええええおおおおおおおおおお',
                ],
                true
            ],
            '商品名が0文字かつ商品説明が0文字の場合' => [
                [
                    'name' => '',
                    'description' => '',
                ],
                false
            ],
            '商品名が11文字かつ商品説明が51文字の場合' => [
                [
                    'name' => 'ああああああああああい',
                    'description' => 'ああああああああああいいいいいいいいいいううううううううううええええええええええおおおおおおおおおおか',
                ],
                false
            ],
            '商品名が10文字かつ商品説明が0文字の場合' => [
                [
                    'name' => 'ああああああああああい',
                    'description' => '',
                ],
                false
            ],
            '商品名が0文字かつ商品説明が50文字の場合' => [
                [
                    'name' => '',
                    'description' => 'ああああああああああいいいいいいいいいいううううううううううええええええええええおおおおおおおおおお',
                ],
                false
            ],
            '商品名が10文字かつ商品説明が51文字の場合' => [
                [
                    'name' => 'ああああああああああ',
                    'description' => 'ああああああああああいいいいいいいいいいううううううううううええええええええええおおおおおおおおおおか',
                ],
                false
            ],
            '商品名が11文字かつ商品説明が50文字の場合' => [
                [
                    'name' => 'ああああああああああい',
                    'description' => 'ああああああああああいいいいいいいいいいううううううううううええええええええええおおおおおおおおおお',
                ],
                false
            ],
        ];
    }
}
