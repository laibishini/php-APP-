<?php
/**
 * Created by PhpStorm.
 * User: Jne
 * Date: 2018/8/16
 * Time: 11:40
 */

namespace app\api\controller;

use think\Controller;

///解决客户端APP时间不一致的问题把数据返回给客户端APP然后在根据自己的时间增减就可以保证验证时间的准确性
class Time extends Controller{
    public function index(){
        return show(1,'ok',time());
    }
}