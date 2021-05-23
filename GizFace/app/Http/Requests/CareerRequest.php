<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CareerRequest extends FormRequest
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
            'company' => 'required',
            'jobTitle' => 'required',
            'from' => 'required',
            'jobDetail' => 'required',
            'scale' => 'integer|required',
            'language.0' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'company.required' => ':attributeは必須です。',
            'jobTitle.required' => ':attributeは必須です。',
            'from.required' => ':attributeは必須です。',
            'jobDetail.required' => ':attributeは必須です。',
            'scale.required' => ':attributeは必須です。',
            'scale.integer' => ':attributeは数値で入力して下さい。',
            'language.0.required' => ':attributeは必須です。',
        ];
    }

    public function attributes()
    {
        return [
            'company' => '会社名',
            'jobTitle' => '業務概要',
            'from' => '開始年月',
            'jobDetail' => '業務内容',
            'scale' => '規模',
            'language.0' => '言語',
        ];
    }
}
