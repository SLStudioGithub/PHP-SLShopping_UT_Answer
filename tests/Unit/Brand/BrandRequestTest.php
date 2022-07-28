<?php

namespace Tests\Unit\Brand;

use App\Admin\Requests\BrandRequest;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

/**
 * ブランドリクエストテスト
 *
 * コマンド実行する場合はプロジェクトのルートディレクトリ上で実行すること
 * $ ./vendor/bin/phpunit ./tests/Unit/Brand/BrandRequestTest.php
 */
class BrandRequestTest extends TestCase
{

    /**
     * 概要 ブランド名の入力チェック
     * 条件 ブランド名が1文字の場合
     * 結果 trueを返すこと
     */
    public function test_ブランド名が1文字の場合trueを返すこと()
    {
        // 入力項目
        $data = [
            'name' => 'あ',
        ];
        $request = new BrandRequest();
        $rules = $request->rules();
        $validator = Validator::make($data, $rules);
        // テスト実施
        $actual = $validator->passes();
        $expected = true;

        // 検証
        $this->assertSame($expected, $actual);        
    }

    /**
     * 概要 ブランド名の入力チェック
     * 条件 ブランド名が10文字の場合
     * 結果 trueを返すこと
     */
    public function test_ブランド名が10文字の場合trueを返すこと()
    {
        $data = [
            'name' => 'ああああああああああ',
        ];
        $request = new BrandRequest();
        $rules = $request->rules();
        $validator = Validator::make($data, $rules);
        $actual = $validator->passes();
        $expected = true;

        /* Lesson02 タスク -初級編- 課題1 */
        // 検証処理
        $this->assertSame($expected, $actual);
    }

    /**
     * 概要 ブランド名の入力チェック
     * 条件 ブランド名が0文字の場合
     * 結果 falseを返すこと
     */
    public function test_ブランド名が0文字の場合falseを返すこと()
    {
        $data = [
            'name' => '',
        ];
        $request = new BrandRequest();
        $rules = $request->rules();
        $validator = Validator::make($data, $rules);
        $actual = $validator->passes();
        $expected = false;

        $this->assertSame($expected, $actual);
    }

    /**
     * 概要 ブランド名の入力チェック
     * 条件 ブランド名が11文字の場合
     * 結果 falseを返すこと
     */
    public function test_ブランド名が11文字の場合falseを返すこと()
    {
        $data = [
            'name' => 'ああああああああああい',
        ];
        $request = new BrandRequest();
        $rules = $request->rules();
        $validator = Validator::make($data, $rules);
        $actual = $validator->passes();
        $expected = false;

        $this->assertSame($expected, $actual);
    }
}
