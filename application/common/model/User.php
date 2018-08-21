<?php
/**
 * Created by PhpStorm.
 * User: Jne
 * Date: 2018/8/14
 * Time: 11:08
 */
namespace app\common\model;

class User extends Base{



    public function getUsersUserId($UserIds = []){

        //开始，ThinkPHP支持对同一个字段多次调用查询条件，例如：字符串条件查询
        $data = [
            'id'=>['in',implode(',',$UserIds)], //in方式使用查询
            'status'=>1,
        ];




        $order = [
          'id'=>'desc',
        ];



        return $this->where($data)
            ->field(['id','username','image'])
            ->order($order)
            ->select();
    }
}