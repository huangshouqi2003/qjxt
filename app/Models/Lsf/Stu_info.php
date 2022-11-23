<?php

namespace App\Models\Lsf;

use Illuminate\Database\Eloquent\Model;

class Stu_info extends Model
{
    protected $table = 'stu_info';
    protected  $primaryKey = 'id';
    public $timestamps = true;

    //通过学号查找邮箱
    public static function lsf_se_em($stu_id,$email)
    {

        try {

            $res = self::where('stu_id',$stu_id)->value('email');
            if ($res!=null){
                return $res;
            }else{
                return false;
            }

        }catch (\Exception $e){
            logError('操作失败',[$e->getMessage()]);
            return false;
        }


    }
}
