<?php

namespace App\Http\Controllers\zm;

use App\Http\Controllers\Controller;
use App\Models\zm\stu_info;
use App\Models\zm\student;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AllinfoController extends Controller
{

    public  function  zmSelect()//查询所有消息
    {

        $res=stu_info::zmselect_user();

        return $res ?
            json_success('操作成功!',$res,'200'):
            json_fail('操作失败!',null,'100');

    }


    public static function zm_get_token(Request $request)//获取token
    {
        $token = $request->header('Authorization');

        $request->headers->set('Authorization', $token);

        $res= self::zm_refresh_token($token);

        return $res;

    }

    public static function zm_refresh_token($jwt)//token验证
    {
        try {
            $decoded = JWT::decode($jwt, new Key('hsq', 'HS256'));//HS256方式，这里要和签发的时候对应
            $arr = $decoded;
            $data=$arr->data;
            $stu_id = $data[0];
            $stu_name = $data[1];

            $create_time= $arr->iat;//获取token创建时间
            $end_time = $arr->exp;//获取token结束时间
            $now_time=time();//获取当前时间

            if (($end_time- $create_time)>($now_time-$create_time)) //判断token是否过期
            {
                //未过期
                $res=array('one'=>true,
                    'two' => 'ok',
                    'three'=> 1,
                    'four'=>1) ;
                return $res;
            }
            else
            {
                //过期
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
    }

    public static function zm_flush_token($stu_id,$stu_name)//刷新token
    {
        $key = 'hsq';
        $payload = [
            "alg" => "HS256",
            "typ" => "JWT",
            'iss' => 'http://example.org',
            'aud' => 'http://example.com',
            'exp' => time() + 180,
            'data' => [$stu_id,
                $stu_name
            ],
            'iat' => time(),
            'nbf' => time()
        ];
        $token = JWT::encode($payload, $key, 'HS256');
        return $token;
    }

    public  function  zmchangetable(Request $request)//修改学生信息
    {

        $key=self::zm_get_token($request);//获取token
        $key1=$key['one'];
        $key2=$key['two'];
        $key3=$key['three'];
        $key4=$key['four'];

        if($key1)
        {
            $param=$request->all();//表单验证
            $rules=[
                'stu_id'=>'required|max:11',
                'stu_name'=>'required|min:2',
                'password'=>'required',
                'email'=>'required',
                'phone_num'=>'required|max:11',
                'teacher'=>'required|min:2',
                'stu_class'=>'required'
            ];
            $message=[
                'stu_id'=>'id',
                'stu_name'=>'名字',
                'password'=>'密码',
                'email'=>'邮箱',
                'phone_num'=>'电话',
                'teacher'=>'老师',
                'stu_class'=>'班级'
            ];
            $attributes=[
                'required'=>':attribute不能为空',
                'max'=>':attribute不能超过:max个字符',
                'min'=>'attribute不能低于:min个字符'
            ];
            $validator=Validator::make($param,$rules,$message,$attributes);

            if($validator->fails())
            {
                return json_fail('修改失败!存在非法输入',null,100);
            }
            else
            {
                    $password = $request['password'];
                    $stu_id = $request['stu_id'];
                    $stu_name = $request['stu_name'];
                    $stu_class = $request['stu_class'];
                    $email = $request['email'];
                    $phone_num = $request['phone_num'];
                    $teacher = $request['teacher'];

                    $res = student::zmtestchange($password, $stu_id);
                    $res2 = stu_info::zmchange_user($stu_id, $stu_name, $stu_class, $email, $phone_num, $teacher);

                    return ($res and $res2) ?
                        json_success('修改成功!', $res, '200') :
                        json_fail('修改失败!请检查是否有该学生或信息是否正常录入', null, '100');
            }
        }
        else
        {
            $new=self::zm_flush_token($key3,$key4);
            return json_fail('操作失败，验证失败（）',$new,'100');
        }
    }

}
