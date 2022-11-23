<?php

namespace App\Models\Lsf;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class Codes extends Model
{
    protected $table = 'code';
    protected  $primaryKey = 'id';
    public $timestamps = true;


    public function lsf_up_code($code)
    {
        try {
            $res = self::where('id', 1)->update()([
                'code' => $code
            ]);
            return $res;
        }catch (\Exception $e){
            logError('操作失败',[$e->getMessage()]);
            return false;
    }
    }

}
