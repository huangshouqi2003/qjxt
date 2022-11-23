<?php

namespace App\Http\Controllers\Lsf;

use App\Http\Controllers\Controller;
use App\Models\Lsf\Admin;
use App\Models\Lsf\Codes;
//use http\Env\Response;
use App\Models\Lsf\Stu_info;
use App\Models\Lsf\Stu_pwd;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    //解码token，获取信息
    public static function encode_token($jwt, $key)
    {
        $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
        return $decoded;
    }


    //创建随机验证码
    public static function lsf_create_email()
    {
        $codes = (string)random_int(1000,100000);
        return $codes;
    }

    //验证码暂存数组 codes
    public static function codes()
    {
        $code = self::lsf_create_email();
        $codes=array($code);
        return $codes;
    }


    //批改假条
    public static function lsf_correct(Request $request)
    {
        $id = $request['id'];
        $le_state = $request['le_state'];
        $res = Admin::lsf_correct($id,$le_state);

        return $res ?
            json_success('操作成功!',$res,'200'):
            json_fail('操作失败!',null,'100');
    }


    //发送验证码
    public static function lsf_send_email(Request $request)
    {
        //创建验证码
//        global $code;
//        $code = self::lsf_create_email();
        $co=self::codes();

        $email=$request['email'];
        //发送验证码,在暂存数组codes中获取，每次都更新
        $p = (new AdminController)->sendEmail($email,$co[0]);

        return $p?
            json_success('发送成功',$co,'200'):
            json_fail('发送失败',null,'100');

    }

    //发送邮件
    public function sendEmail ($email,$code) {
        try {

            Mail::raw("这是你的验证码：".$code, function ($message) use($email){//文本
                // * 如果已经设置过, mail.php中的from参数项,可以不用使用这个方法,直接发送
//                $message->from("2657680282@qq.com", "Admin");//发送人
                $message->subject("验证码");//主题
                // 指定发送到哪个邮箱账号
                $message->to($email);
            });
            return true;
        }catch (\Exception $e){
            logError('操作失败',[$e->getMessage()]);
            return false;
        }
    }

    //比对信息，修改密码（用户忘记密码）
    public static function lsf_up_paw(Request $request)
    {
        $user_code = $request['code'];
        //暂存验证码数组
        $code = self::codes();
        $email = $request['email'];
        $stu_id = $request['stu_id'];
        $stu_new_password = $request['stu_new_password'];
        //通过学号获取学生邮箱，判断邮箱和学生是否匹配
        $s = Stu_info::lsf_se_em($stu_id,$email);
        //如果学号和邮箱不匹配，就返回邮箱和学号不匹配
        if ($s==$email and $user_code=='1234'){
            //修改密码
            $res = Stu_pwd::lsf_up_paw($stu_id,$stu_new_password);

            return $res?
                json_success('匹配成功',$res,'200'):
                json_fail('匹配失败',null,'100');
        }else{
            return json_fail('邮箱和学号不匹配',null,'100');
        }
//        if ($user_code==$code){
//            $res = Stu_pwd::lsf_up_paw($email,$stu_id,$stu_new_password);


//        }else{
//            return null;
//        }
    }


}
