<?php

namespace App\Http\Controllers\hsq;

use App\Http\Controllers\Controller;
use App\Http\Controllers\text;
use App\Models\hsq\hsq_stu_info;
use App\Models\hsq\hsq_zhucetwo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class hsq_enroll extends Controller
{
    var $temp;
    public function hsq_send_email(Request $request)
    {
        $num=rand(1000,9999);
        $this->temp=$num;
        $email='1770960700@qq.com';
        $data= array('name'=>$num);
        Mail::send('kf',$data, function($message) use($email)
        {
            $message->to($email)->subject('验证码');
        });
        return redirect()->action(hsq_enroll::add_user($request,$num));
    }
    public static function add_user(Request $request,$code)
    {
        echo $code;
        $flag=hsq_stu_info::hsq_insert_student($request);
        $flag1=hsq_zhucetwo::hsq_insert_password($request);

        if($flag!=1 and $flag1!=1)
        {
            return response()->json(['data'=>'注册失败']);
        }
        elseif ($flag==1 and $flag1!=1)
        {
            hsq_stu_info::dd1($request);
            return response()->json(['data'=>'注册失败']);
        }
        elseif ($flag!=1 and $flag1==1)
        {
            hsq_zhucetwo::dd2($request);
            return response()->json(['data'=>'注册失败']);
        }
        else
        {
            return response()->json(['data'=>'注册成功']);
        }

    }
}
