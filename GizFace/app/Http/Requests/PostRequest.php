<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
        return [
            'title' => 'required',
            'category' => 'not_in: 0',
            'body' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => ':attributeは必須です。',
            'category.not_in' => ':attributeを選択してください。',
            'body.required' => ':attributeは必須です。',
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'タイトル',
            'category' => 'カテゴリー',
            'body' => '内容',
        ];
    }
}
