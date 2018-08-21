<?php
/**
 * Created by PhpStorm.
 * User: Jne
 * Date: 2018/8/15
 * Time: 9:49
 */

namespace app\api\controller;

use app\common\lib\Aes;
use app\common\lib\exception\ApiException;
use app\common\lib\IAuth;
use app\common\lib\Message;
use think\Controller;

/*'default_return_type'=>'json' 需要在api comfig文件开启这个返回json方式*/
class Test extends Common {

    public function  index(){

    }

    public function update($id = 0){

        $data = input('put.');




        return $id;

    }

    public function save(){

        $data = input('post.');










        return show(1,'ok',(new Aes())->encrypt(json_encode(input('post.'))),201);


    }




}