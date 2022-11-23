<?php

namespace App\Models\hsq;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class hsq_student extends Model
{
    protected $table = 'student';
    protected $primaryKey = 'id';
    protected $fillable = ['stu_id','password'];
    public $timestamps = true;


    public static  function hsq_denglus($request)
    {
        try
        {
            $stu_id=self::firstwhere('stu_id',$request->input('stu_id'));//查询账号
        }
        catch (\Exception $e)
        {
            return 0;
        }
        try {
            $password=self::firstwhere('password',$request->input('password'));//查询密码
        }
        catch (\Exception $e)
        {
            return 0;
        }
        if($stu_id['id']==null||$password['password']==null)//都为空返回500
        {
            return 0;
        }
        else
        {
            return response()->json(['data'=>$stu_id],200);
        }

    }
}
