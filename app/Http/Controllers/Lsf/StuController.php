<?php

namespace App\Http\Controllers\Lsf;

use App\Http\Controllers\Controller;
use App\Models\Lsf\Stu_pwd;
//use http\Env\Response;
use Illuminate\Http\Request;

class StuController extends Controller
{

    //学生忘记密码
    public static function stu_fg(Request $request)
    {
        $email = $request['email'];
        $stu_id = $request['stu_id'];
        $stu_new_password = $request['$stu_new_password'];
        $code = $request['code'];

        $res = Stu_pwd::lsf_forget($email,$stu_id,$stu_new_password,$code);
        return $res ?
            json_success('操作成功!',$res,'200'):
            json_fail('操作失败!',null,'100');
    }
}
