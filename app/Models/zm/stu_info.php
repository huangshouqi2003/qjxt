<?php

namespace App\Models\zm;

use Illuminate\Database\Eloquent\Model;

class stu_info extends Model
{
    public $table='stu_info';
    public $primaryKey='id';
    protected $fillable=[
        'stu_id','stu_name','email','phone_num','teacher'
    ];
    public $timestamps=true;

    public static function zmselect_user()
    {

        try{
            $info=self::all();
            return $info;
        }catch(\Exception $key){
            logError('查询失败',[$key->gteMessage()]);
            return false;
        }

    }

    public static function zmchange_user($stu_id,$stu_name,$stu_class,$email,$phone_num,$teacher)
    {

        try {
            $res=self::where('stu_id','=',$stu_id)->update([
                'stu_id'=>$stu_id,
                'stu_name'=>$stu_name,
                'stu_class'=>$stu_class,
                'email'=>$email,
                'phone_num'=>$phone_num,
                'teacher'=>$teacher
            ]);
            return $res;
        }catch(\Exception $key){
            logError('修改失败',[$key->gteMessage()]);
            return false;
        }

    }
}
