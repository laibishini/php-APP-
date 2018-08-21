<?php
/**
 * Created by PhpStorm.
 * User: Jne
 * Date: 2018/8/14
 * Time: 11:08
 */
namespace app\common\model;

class Version extends Base{

   public  function getLastNormalVersionByAppType($appType =''){


       $data = [
           'status'=>1,
           'app_type' =>$appType,
       ];

       $order = [
           'id'=>'desc',
       ];


       $result = $this->where($data)
           ->order($order)
           ->limit(1)
           ->find();


       return $result;


   }

}