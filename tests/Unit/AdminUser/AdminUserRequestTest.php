<?php

namespace Tests\Unit\Brand;

use App\Admin\Requests\AdminUserRequest;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

/**
 * 商品リクエストテスト
 *
 * コマンド実行する場合はプロジェクトのルートディレクトリ上で実行すること
 * $ ./vendor/bin/phpunit ./tests/Unit/AdminUser/AdminUserRequestTest.php
 */
class AdminUserRequestTest extends TestCase
{

    /**
     * 概要 管理者ID・管理者名のパラメーター化テスト
     * 条件 データプロバイダメソッドのラベル
     * 結果 条件に応じた結果(true, false)を返すこと
     * 
     * @dataProvider validationDataProvider
     */
    public function test_パラメーター化テスト($param, $expected)
    {
        $request = new AdminUserRequest();
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
            '管理者IDが10文字かつ管理者名が1文字の場合' => [
                [
                    'userId' => 'ああああああああああ',
                    'userName' => 'あ',
                ],
                true
            ],
            '管理者IDが50文字かつ管理者名が10文字の場合' => [
                [
                    'userId' => 'ああああああああああいいいいいいいいいいううううううううううええええええええええおおおおおおおおおお',
                    'userName' => 'ああああああああああ',
                ],
                true
            ],
            '管理者IDが50文字かつ管理者名が1文字の場合' => [
                [
                    'userId' => 'ああああああああああいいいいいいいいいいううううううううううええええええええええおおおおおおおおおお',
                    'userName' => 'あ',
                ],
                true
            ],
            '管理者IDが10文字かつ管理者名が10文字の場合' => [
                [
                    'userId' => 'ああああああああああ',
                    'userName' => 'ああああああああああ',
                ],
                true
            ],
            '管理者IDが0文字かつ管理者名が0文字の場合' => [
                [
                    'userId' => '',
                    'userName' => '',
                ],
                false
            ],
            '管理者IDが51文字かつ管理者名が11文字の場合' => [
                [
                    'userId' => 'ああああああああああいいいいいいいいいいううううううううううええええええええええおおおおおおおおおおか',
                    'userName' => 'ああああああああああい',
                ],
                false
            ],
            '管理者IDが50文字かつ管理者名が0文字の場合' => [
                [
                    'userId' => 'ああああああああああいいいいいいいいいいううううううううううええええええええええおおおおおおおおおお',
                    'userName' => '',
                ],
                false
            ],
            '管理者IDが0文字かつ管理者名が10文字の場合' => [
                [
                    'userId' => '',
                    'userName' => 'ああああああああああ',
                ],
                false
            ],
            '管理者IDが50文字かつ管理者名が11文字の場合' => [
                [
                    'userId' => 'ああああああああああいいいいいいいいいいううううううううううええええええええええおおおおおおおおおお',
                    'userName' => 'ああああああああああい',
                ],
                false
            ],
            '管理者IDが51文字かつ管理者名が10文字の場合' => [
                [
                    'userId' => 'ああああああああああいいいいいいいいいいううううううううううええええええええええおおおおおおおおおおか',
                    'userName' => 'ああああああああああ',
                ],
                false
            ],
        ];
    }
}
