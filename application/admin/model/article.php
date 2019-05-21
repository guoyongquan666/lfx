<?php
/**
 * Created by PhpStorm.
 * User: qingyun
 * Date: 19/5/20
 * Time: 下午8:01
 */


namespace app\admin\model;

use think\Model;

class article extends Model
{
<<<<<<< HEAD
    //自动事件
    protected $autoWriteTimestamp = true;

    public function category()
    {

        return $this->belongsTo('category','category_id');

    }

=======
    //
>>>>>>> fbc347d328db6b6935da8127619b327d8fffc5f8
}