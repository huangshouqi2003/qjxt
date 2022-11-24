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
            'password' => 'required|min:6|max:15',
            'stu_name'=>'required|min:1|max:8',
            'stu_class'=>'required|min:1|max:15',
            'phone_num'=>'required|min:11|max:11',
            'teacher'=>'required|min:1|max:8',
            'code'=>'required|min:0|max:5',
            'email'=>['required','min:12','max:20',
                'regex:/[1-9]([0-9]{5,11}@qq.com)/'
            ]
        ];
    }

    public function messages()
    {
        return [
            'stu_id.max' => '只能为11位',
            'stu_id.min' => '只能为11位',
            'stu_id.required' => '学号必填',
            'password.max' => '密码为6-15位',
            'password.min' => '密码为6-15位',
            'password.required' => '密码必填',
            'stu_name.min'=>'姓名输入太短',
            'stu_name.max'=>'姓名输入太长',
            'stu_name.required'=>'姓名必填',
            'stu_class.min'=>'班级输入太短',
            'stu_class.max'=>'班级输入太长',
            'stu_class.required'=>'班级必填',
            'phone_num.min'=>'电话号码不为11位',
            'phone_num.max'=>'电话号码不为11位',
            'phone_num.required'=>'电话号码必填',
            'teacher.min'=>'辅导员姓名太短',
            'teacher.required'=>'辅导员姓名必填',
            'teacher.max'=>'辅导员姓名太长',
            'code.min'=>'验证码太短',
            'code.max'=>'验证码太长',
            'code.required'=>'验证码必填',
            'email.regex'=>'邮箱格式不对',
            'email.min'=>'邮箱太短',
            'email.max'=>'邮箱太长',
            'email.required'=>'邮箱必填'
        ];
    }
}
