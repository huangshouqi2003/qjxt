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
            'email' => ['required',
                'min:12',
                'max:17',
                'regex:/[1-9]([0-9]{5,11}@qq.com)/'
            ]
        ];
    }
    public function messages(){
        return [

            'email.required' => '邮箱不能为空',
            'email.regex' => '邮箱格式应该是qq+@qq.com',
            'email.max' => '邮箱长度超出正常长度',
            'email.min' => '邮箱长度低于正常长度'
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

