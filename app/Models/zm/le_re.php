<?php

namespace App\Models\zm;

use Illuminate\Database\Eloquent\Model;

class le_re extends Model
{
    public  $table='le_re';
    public $primaryKey='id';
    protected $fillable=[
        'stu_id','stu_name','le_type','le_why','le_state'
    ];
    public $timestamps=true;

    public static function zmselectle()
    {
        try {
            $info1 = self::select('*')->where('le_state', '=', '已通过')->get();
            $info2 = self::select('*')->where('le_state', '=', '未通过')->get();
            $info3 = self::select('*')->where('le_state', '=', '审核中')->get();

            $info4=$info1.$info2.$info3;
            return $info4;
        } catch (\Exception $key) {
            logError('查询失败', [$key->gteMessage()]);
            return false;
        }
    }
}
