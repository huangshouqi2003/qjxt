<?php

namespace App\Models\zm;

use Illuminate\Database\Eloquent\Model;

class student extends Model
{
    public  $table='student';
    public $primaryKey='id';
    protected $fillable=[
        'stu_id','password'
    ];
    public $timestamps=true;

    public static function zmtestchange($password,$stu_id)
    {

        try {
            $res=self::where('stu_id','=',$stu_id)->update([
                'password'=>$password

            ]);
            return $res;
        }catch(\Exception $key){
            logError('修改失败',[$key->gteMessage()]);
            return false;
        }

    }
}
