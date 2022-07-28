<?php

namespace App\Admin\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * カテゴリー編集バリデーションクラス
 */
class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        /**
         * カテゴリー名: 必須|文字列|最大20文字
         * 親カテゴリー: 必須|整数
         */
        return [
            'name' => 'required|string|max:20',
        ];
    }

    /**
     * バリデーション項目名定義
     * 
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => 'カテゴリー名',
        ];
    }
}
