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
                'min:10000000',
                'max:100000000000',
                'regex:([1-9]\d*)',
                'integer'
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
//            'name.unique' => '用户名已被占用，请重新填写',
//            'name.regex' => '用户名只支持英文、数字、横杠和下划线。',
//            'name.between' => '用户名必须介于 3 - 25 个字符之间。',
//            'name.required' => '用户名不能为空。',
        ];
    }



    public function failedValidation(Validator $validator){

        throw(new HttpResponseException(json_fail('参数错误',$validator->errors()->all(),422)));
    }
}

