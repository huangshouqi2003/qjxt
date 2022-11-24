<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class hsq_yanzhen_zhuce extends hsq_base_yanzhen
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
            'stu_id' => 'required|min:11|max:11',
            'password' => 'required|min:6|max:15'
        ];
    }

    public function messages()
    {
        return [
            'stu_id.max' => '只能为11位',
            'stu_id.min' => '只能为11位',
            'stu_id.required' => '必填',
            'password.max' => '密码为6-15位',
            'password.min' => '密码为6-15位',
            'password.required' => '必填',
        ];
    }
}
