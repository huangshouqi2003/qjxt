<?php

namespace App\Models\Lsf;

use Illuminate\Database\Eloquent\Model;

class Stu_pwd extends Model
{
    protected $table = 'student';
    protected  $primaryKey = 'id';
    public $timestamps = true;
//    protected $fillable = ['le_state'];
//    protected $hidden = [
//        'password'
//    ];

//    public static function lsf_forget($email,$stu_id,$stu_new_password,$code)
//    {
//        try {
//            if ($email == $code){
//                $res = self::where('stu_id', $stu_id)->update([
//                    'password' => $stu_new_password
//                ]);
//                return $res;
//            }else{
//                return null;
//            }
//
//        }catch (\Exception $exception){
//            logError('操作失败',[$exception->getMessage()]);
//            return false;
//        }
//    }
    //通过学号修改学生密码（忘记密码接口）
    public static function lsf_up_paw($stu_id,$stu_new_password)
    {
        try {

            $res = self::where("stu_id", $stu_id)->update([
                'password'=>$stu_new_password
            ]);

            return $res;
        }catch (\Exception $e){
            logError('操作失败',[$e->getMessage()]);
            return false;
        }
    }
}
