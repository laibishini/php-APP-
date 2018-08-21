<?php
/**
 * Created by PhpStorm.
 * User: Jne
 * Date: 2018/8/16
 * Time: 14:28
 */

namespace app\api\controller\v1;

use app\api\controller\Common;
use app\common\lib\exception\ApiException;
use app\common\lib\Message;
use app\common\lib\Page;
use think\Controller;
use think\exception\Handle;

/*设计手机短信验证码*/

class Identify extends Common {

    /*设置手机短信验证码*/
    public  function save(){

    if(!request()->isPost()){
        return show(config('code.error'),'您提交的数据不合法',[],403);
    }

        //检验数据
        $validate = validate('Identify');

        //做个判断
        if(!$validate->check(input('post.'))){

            return show(config('code.error'),$validate->getError(),[],403);

        }


        $id = input('param.id');
        $code = mt_rand(1000,9999);//随机的手机验证码
        ///验证码有效期你自己可以配置
        $expire = config('Message.expire_time');
        $tempId = config('Message.tempId');
        $datas = array($code,$expire);

        $res = Message::sendTemplateSMS($id,$datas,$tempId);



        if($res === true){
            return show(config('code.success'),'ok',201);

        }else{
            return show(config('code.error'),'验证码错误',$res->statusMsg,403);

        }


    }

}