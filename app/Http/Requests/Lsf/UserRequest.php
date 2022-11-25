<?php

namespace App\Http\Requests\Lsf;


use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
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
                'min:11',
                'max:11',
                'regex:([1-9]\d*)',
            ]
        ];
    }
    public function messages(){
        return [

            'stu_id.required' => '学号不能为空',
            'stu_id.regex' => '学号格式应该整形',
            'stu_id.max' => '学号长度超出正常长度',
            'stu_id.min' => '学号长度低于正常长度',
            'stu_id.integer' => '学号应该是整形'

        ];
    }



    public function failedValidation(Validator $validator){

        throw(new HttpResponseException(json_fail('参数错误',$validator->errors()->all(),422)));
    }
}

