<?php

namespace App\Models\Lsf;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'le_re';
    protected  $primaryKey = 'id';
    public $timestamps = true;
//    protected $fillable = ['le_state'];
//    protected $hidden = [
//    ];
    //通过假条id批阅假条，修改状态
    public static function lsf_correct($id,$le_state)
    {
        try {
            $res = self::where('id',$id)->get();
            if ($res!=null) {
                $res = self::where('id', $id)->update([
                    'le_state' => $le_state
                ]);
                return $res;
            }else{
                return null;
            }
        }catch (\Exception $e)
        {
            logError('操作失败',[$e->getMessage()]);
            return false;
        }
    }

}
