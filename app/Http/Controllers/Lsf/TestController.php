<?php

namespace App\Http\Controllers\Lsf;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;

class TestController extends Controller
{

    public static function encode_token($jwt, $key)
    {
        $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
        return $decoded;
    }


    public static function create_email()
    {
        $code = (string)random_int(1000, 10000);
        return $code;
    }

    public function st()
    {

        $to = "1770960700@qq.com";         // 邮件接收者
        $subject = "参数邮件";                // 邮件标题
        $message = "Hello! 这是邮件的内容。";  // 邮件正文
        $from = "someonelse@example.com";   // 邮件发送者
        $headers = "From:" . $from;         // 头部信息设置
        mail($to, $subject, $message, $headers);
        echo "邮件已发送";

    }


    public function sendEmail()
    {
        $code = self::create_email();
        $email = '2657680282@qq.com';
        try {

            Mail::raw("这是你的验证码：" . $code, function ($message) {//文本
                // * 如果你已经设置过, mail.php中的from参数项,可以不用使用这个方法,直接发送
                $message->from("2657680282@qq.com", "Admin");//发送人
                $message->subject("验证码");//主题
                // 指定发送到哪个邮箱账号
                $message->to("2657680282@qq.com");
            });
            return 1;
        } catch (\Exception $e) {
            logError('操作失败', [$e->getMessage()]);
            return null;
        }
    }


    public static function creat_token(Request $request)
    {
        $key = 'hsq';
        $payload = [
            "alg" => "HS256",
            "typ" => "JWT",
            'iss' => 'http://example.org',
            'aud' => 'http://example.com',
            'exp' => time() + 180,
            'data' => [$request->input('stu_id'),
                $request->input('stu_name')
            ],
            'iat' => time(),
            'nbf' => time()
        ];
        $token = JWT::encode($payload, $key, 'HS256');
        return $token?
            json_success('操作成功!',$token,'100'):
            json_fail('操作失败!',null,'200');


    }
}
