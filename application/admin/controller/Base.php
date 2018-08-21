<?php
/**
 * Created by PhpStorm.
 * User: Jne
 * Date: 2018/8/11
 * Time: 9:40
 */

//后台基础类库
namespace app\admin\controller;

use think\Controller;

class Base extends Controller{

    public $page = '';

    public $size = '';

    //查询条件的起始值
    public $from = 0;

    //初始化方法防跳墙验证 谁继承这个类就立马初始化initialize这个方法

    public function _initialize()
    {

       $isLogin=  $this->isLogin();

       if(!$isLogin){
           return $this->redirect('login/index');
       }
    }

    //判断是不是登录

    public function isLogin(){

        //获取session

        $user =  session(config('admin.session_user'),'',config('admin.session_user_scope'));

        if($user && $user->id){
            //如果没有说明不存在
            return true;

        }

        return false;
    }






}