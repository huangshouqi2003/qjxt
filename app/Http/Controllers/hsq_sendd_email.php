<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class hsq_sendd_email extends Controller
{
    public static function basic_email()
    {
        $num=rand(1000,9999);
        $email='1770960700@qq.com';
        $data= array('name'=>$num);
        Mail::send('kf',$data, function($message) use($email)
        {
            $message->to('3197088748@qq.com')->subject('验证码');
        });
        return $num;
    }
}
