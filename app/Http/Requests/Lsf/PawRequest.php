<?php

namespace App\Http\Requests\Lsf;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PawRequest extends FormRequest
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
            'stu_id' => ['required',
                'min:10',
                'max:12',
                'regex:([1-9]\d*)'
            ],
            'stu_new_password' => [
                'between:6,15',
                'required',
            ],

        ];
    }

    public function messages(){
        return [
            'stu_id.required' => '学号不能为空',
            'stu_id.regex' => '学号必须是整形',
            'stu_id.max' => '学号过长',
            'stu_id.min' => '学号过短',

            'stu_new_password.required' => '密码不能为空',
            'stu_new_password.between' => '密码必须介于 6 - 15 位之间',

        ];
    }

    public function failedValidation(Validator $validator){

        throw(new HttpResponseException(json_fail('参数错误',$validator->errors()->all(),422)));
    }
}
