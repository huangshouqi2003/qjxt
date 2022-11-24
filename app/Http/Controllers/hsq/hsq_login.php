<?php

namespace App\Http\Controllers\hsq;

use App\Http\Controllers\Controller;
use App\Http\Requests\hsq_yanzhen_denlu;
use App\Models\hsq\hsq_student;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;

class hsq_login extends Controller
{
    public static function creat_token(hsq_yanzhen_denlu $request)
    {
        $key = 'hsq';
        $payload = [
            "alg" => "HS256",
            "typ" => "JWT",
            'iss' => 'http://example.org',
            'aud' => 'http://example.com',
            'exp' =>  time()+3600,
            'data' => [$request->input('stu_id'),
                $request->input('password')
            ],
            'iat' => time(),
            'nbf' => time()
        ];
        $token = JWT::encode($payload, $key, 'HS256');
        return $token;
    }
    public static function encode_token($jwt,$key)
    {
        $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
        return $decoded;
    }
    public static function dd(hsq_yanzhen_denlu $request)
    {
        $gg = hsq_student::hsq_denglus($request);
        if($gg=='0')//账号密码输入有误
        {
            return response()->json(['data'=>'账号密码有误']);
        }
        $data=$gg->getData();
        $data=$data->data;//取出查询的数据
        $token=self::creat_token($request);//生成token
        return response()->json(['data'=>$data,'token'=>$token],200);
    }
}
