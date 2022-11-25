<?php

namespace App\Http\Controllers\Lsf;

use App\Http\Controllers\Controller;
use App\Http\Requests\Lsf\NoteRequest;
use App\Http\Requests\Lsf\PawRequest;
use App\Http\Requests\Lsf\UserRequest;
use App\Models\Lsf\Admin;
use App\Models\Lsf\Stu_info;
use App\Models\Lsf\Stu_pwd;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

//use http\Env\Response;

class AdminController extends Controller
{
    // 获取token并且验证token是否过期
    public static function lsf_get_token(Request $request)
    {
        $token = $request->header('Authorization');

        $request->headers->set('Authorization', $token);

        $res= self::lsf_refresh_token($token);

        return $res;

    }

    //token验证
    public static function lsf_refresh_token($jwt)
    {
        try {
            JWT::$leeway = 60;//当前时间减去60，把时间留点余地
            $decoded = JWT::decode($jwt, new Key('hsq', 'HS256'));//HS256方式，这里要和签发的时候对应
            $arr = $decoded;
            $data=$arr->data;
            $stu_id = $data[0];
            $stu_name = $data[1];


            //获取token创建时间
            $create_time= $arr->iat;
            //获取token结束时间
            $end_time = $arr->exp;
            //获取当前时间
            $now_time=time();
            //判断token是否过期
            if (($end_time- $create_time)>($now_time-$create_time))
            {
                //未过期
                $res=array('one'=>true,
                    'two' => 'ok',
                    'three'=> 1,
                    'four'=>2) ;
                return $res;
            }else {
                //过期\
                $res=array('one'=>false,
                    'two'=>'out',
                    'three'=>$stu_id,
                    'four'=>$stu_name);
                return $res;
            }

        } catch (\Firebase\JWT\SignatureInvalidException $e) {  //签名不正确
             logError($e->getMessage());
             return false;
        } catch (\Firebase\JWT\BeforeValidException $e) {  // 签名在某个时间点之后才能用
            logError($e->getMessage());
            return false;
        } catch (\Firebase\JWT\ExpiredException $e) {  // token过期
            logError($e->getMessage());
            return false;
        } catch (\Exception $e) {  //其他错误
            logError($e->getMessage());
            return false;
        }
        //Firebase定义了多个 throw new，我们可以捕获多个catch来定义问题，catch加入自己的业务，比如token过期可以用当前Token刷新一个新Token
    }


    //创建随机验证码
    public static function lsf_create_email()
    {
        $code = (string)random_int(1000,9999);
        return $code;
    }


    //批改假条
    public static function lsf_correct(NoteRequest $request)
    {
        $s=self::lsf_get_token($request);
        $s1=$s['one'];//false
        $s2=$s['two'];//out
        $s3 = $s['three'];
        $s4 = $s['four'];
        if ($s1)
        {
            $id = $request['id'];
            $le_state = $request['le_state'];
            $res = Admin::lsf_correct($id,$le_state);

            return $res ?
                json_success('审核成功!',$res,'200'):
                json_fail('审核失败!查无此假条！',null,'100');
        }else if ($s2=='out') {
            $new_token = self::lsf_flush_token($s3,$s4);
            return json_fail('token已过期',$new_token,100);
        }else{
            return json_fail('token不存在',null,100);
        }
    }

    //刷新token
    public static function lsf_flush_token($stu_id,$stu_name)
    {
        $key = 'hsq';
        $payload = [
            "alg" => "HS256",
            "typ" => "JWT",
            'iss' => 'http://example.org',
            'aud' => 'http://example.com',
            'exp' => time() + 3600,
            'data' => [$stu_id,
                $stu_name
            ],
            'iat' => time(),
            'nbf' => time()
        ];
        $token = JWT::encode($payload, $key, 'HS256');
        return $token;
    }

    //发送验证码
    public static function lsf_send_email(UserRequest $request)
    {
        //创建验证码
        $co=self::lsf_create_email();

        $email=$request['email'];

        $stu_id=$request['stu_id'];
        //发送验证码,每次都更新
        $res=Stu_info::lsf_se_em($stu_id);

        $p = (new AdminController)->sendEmail($res,$co);

        return $p?
            json_success('发送成功',$co,'200'):
            json_fail('发送失败，邮箱有误或不存在',null,'100');
    }

    //发送邮件
    public function sendEmail ($email,$code) {
        try {

            Mail::raw("这是你的验证码：".$code, function ($message) use($email){//文本
                // * 如果已经设置过, mail.php中的from参数项,可以不用使用这个方法,直接发送
//                $message->from("serein0311@qq.com", "Admin");//发送人
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
    public static function lsf_up_paw(PawRequest $request)
    {

        $stu_id = $request['stu_id'];
        $stu_new_password = $request['stu_new_password'];

        $res = Stu_pwd::lsf_up_paw($stu_id,$stu_new_password);

        return $res?
            json_success('修改成功',$res,'200'):
            json_fail('修改失败，用户不存在',null,'100');

    }


}
