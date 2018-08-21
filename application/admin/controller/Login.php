<?php
namespace app\admin\controller;

use app\common\lib\IAuth;
use think\Config;
use think\Controller;

class Login extends Base

{
    //覆盖登录初始化方法为空 为什么这样做因为base方法总认为你没登录你一初始化就没登录所以覆盖置空
    public function _initialize()
    {

    }

    public function index()
    {
        $islogin = $this->isLogin();

        //如果你登录了就显示页面登录也要防跳转
        if($islogin){
            //如果你登录就跳转到首页
            return $this->redirect('index/index');
        }else{
            //否则就显示登录页面
            return $this->fetch();
        }


    }

    public function check(){
        //验证码创建获取所有提交来的表单数据
        //1、判断是不是post提交
        if(request()->isPost()){

            $data = input('post.');
            //这个函数一键搞定验证码操作
            if(!captcha_check($data['code'])){
                $this->error('验证码不正确');
            }
            try {
                //判断用户名密码是不是存在我 们要查询用户名去查询
                $user = model('AdminUser')->get(['username' => $data['username']]);


            }catch (\Exception $e){
                $this->error($e->getMessage());
            }
            if(!$user || $user->status != config('code.status_normal')){
                $this->error('该用户不存在');
            }




            //在对密码进行校验
            if(IAuth::setPassword($data['password']) != $user['password']){
                $this->error('密码不正确');
            }

            //登陆成功
            //1、我们需要更新数据库、登陆时间、登陆的IP做一个更新
            //2、把用户信息保存到session中
            $udata = [

                'last_login_time' => time(),
                'last_login_ip'   =>request()->ip(),

            ];

            try{
            //实例化模型对象
            model('AdminUser')->save($udata,['id' =>$user->id]);
            }catch (\Exception $e){


                $this->error($e->getMessage());
            }


            //2 session 第三个参数是作用域 登陆成功就把数据写入到session中
            session(config('admin.session_user'),$user,config('admin.session_user_scope'));

            $this->success('登陆成功','index/index');




        }else{
            $this->error('请求不合法');
        }

    }


}
