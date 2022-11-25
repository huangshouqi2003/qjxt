<?php

namespace App\Http\Requests\Lsf;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class NoteRequest extends FormRequest
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
            'id' => ['required',
                'min:1',
                'max:100000',
                'regex:([1-9]\d*)',
                'integer'
            ],
            'le_state' => [
                'between:1,5',
                'required'
            ]
        ];
    }

    public function messages(){
        return [
            'id.required' => 'id不能为空',
            'id.integer' => 'id必须是整形',
            'id.max' => 'id长度异常',
            'id.min' => 'id长度不能低于1',
            'id.regex' => 'id必须是整形',

            'le_state.required' => '批改状态不能为空',
            'le_state.between' => '假条状态必须介于 1 - 5 个字符之间',
//            'name.unique' => '用户名已被占用，请重新填写',

        ];
    }

    public function failedValidation(Validator $validator){

        throw(new HttpResponseException(json_fail('参数错误',$validator->errors()->all(),422)));
    }
}
