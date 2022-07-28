<?php

namespace App\Admin\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * ブランド編集バリデーションクラス
 */
class BrandRequest extends FormRequest
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
         * ブランド名: 必須|文字列|最大10文字
         */
        return [
            'name' => 'required|string|max:10',
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
            'name' => 'ブランド名',
        ];
    }
}
