<?php
/**
 * Created by PhpStorm.
 * User: qingyun
 * Date: 19/5/28
 * Time: 下午4:49
 */

namespace app\admin\model;

use think\Model;

class images extends Model
{


    //
    protected $autoWriteTimestamp = true;

    public function category()
    {

        return $this->belongsTo('images','category_id','location');

    }

}