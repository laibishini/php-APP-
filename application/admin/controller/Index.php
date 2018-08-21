<?php
namespace app\admin\controller;

use think\Controller;
use think\Session;

class Index extends Base
{
    public function index()
    {



        //默认加载模版
       return $this->fetch();

    }

    public function welcome(){


        return "hello";



    }

    public function logout(){
        //用这个作用域删除session的好处是它可以定义别的session名字比如wenti session名字我们就可以定义在同一个作用域下面一删除全都删除了
        session(null,config('admin.session_user_scope'));

        //跳转
        $this->redirect('login/index');

    }
}
