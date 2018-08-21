<?php
/**
 * Created by PhpStorm.
 * User: Jne
 * Date: 2018/8/16
 * Time: 14:28
 */

namespace app\api\controller\v1;

use app\api\controller\Common;
use app\common\lib\Aes;
use app\common\lib\exception\ApiException;
use app\common\lib\IAuth;
use app\common\lib\Message;
use app\common\lib\Page;
use think\Config;
use think\Controller;

class Login extends Common {


    //手机号验证码登录，或者手机号密码登录
    public function save(){

        if(!request()->isPost()){
            return show(config('code.error'),'您没有权限',[],404);
        }

        $param  = input('param.');


        if(empty($param['phone'])){
            return show(config('code.error'),'手机不合法',[],404);
        }


        //手机密码登录
        if(empty($param['code']) && empty($param['password'])){
            return show(config('code.error'),'手机验证码不合法或者密码不合法',[],404);

        }




        //需要validate严格验证暂时不写

        //返回获取缓存里面的数据看有没有验证码这个数据

        //如果传入过来的表单中存在这个code是走验证码的方式
        if(!empty($param['code'])){

        $code = IAuth::checkSmsIdentify($param['phone']);
        if($code != $param['code']){
            return show(config('code.error'),'手机验证码不合法',[],404);

        }

        }


        if(!empty($param['code'])) {
            if ($code != $param['code']) {

                return show(config('code.error'), '手机短信验证码不正确', [], 404);


            }

        }

        //有就说明验证码和传输的验证码是正确的

        //第一次登陆要注册数据
        $token = IAuth::setAppLoginToken($param['phone']);

        $data = [
            'token' => $token,
            'time_out' => strtotime("+".config('Message.login_time_out_day')."days"),

        ];

        //查询这个手机号是不是存在
        $user = model('User')->get(['phone'=>$param['phone']]);

        if($user && $user->status==1){

            //密码登录你先要保证用户名是存在的
            if(!empty($param['password'])){
                if(IAuth::setPassword($param['password']) != $user->password){

                    return show(config('code.error'),'密码不正确',[],403);


                }
            }

            //如果存在就更新数据表的数据
            $id = model('User')->save($data,['phone'=>$param['phone']]);
        }else{

            if(!empty($param['code'])){


            $data['username'] = 'singwa粉-'.$param['phone'];
            $data['status'] = 1;
            $data['phone'] = $param['phone'];


            $id = model('User')->add($data);

            }else{
                return show(config('code.error'),'用户不存在',[],403);

            }
        }


        // RRKtdA2pFjq2qp0CdgPomYIRd5HvS7TxuW+jPjurolfUuhXi2Vm9kuoY2wcbMulO


        //插入数据后返回它的id用户


        $obj = new Aes();
        //返回给客户端的token
        if($id){
            $result = [
                'token'=> $obj->encrypt($token."||".$id),

            ];

            return show(config('code.success'),'ok',$result,200);

        }else{
            return show(config('code.error'),'登陆失败',[],403);

        }




    }
}