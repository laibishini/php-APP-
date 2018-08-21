<?php
/**
 * Created by PhpStorm.
 * User: Jne
 * Date: 2018/8/10
 * Time: 16:02
 */

namespace app\common\model;

use think\Model;

class Base extends Model{
    //自动把我们的当前时间插入库
    protected $autoWriteTimestamp = true;
    public function add($data){



        //如果你不是数组我们还要抛个异常
        if(!is_array($data)){
            exception('传递的数据不合法');
        }

        //如果你数组里面的字段在表里面是没有的它就可以过滤掉
        $this->allowField(true)->save($data);
        //然后插入数据的主键id
        return $this->id;
    }
}