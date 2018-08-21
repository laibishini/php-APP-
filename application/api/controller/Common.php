<?php
/**
 * Created by PhpStorm.
 * User: Jne
 * Date: 2018/8/15
 * Time: 17:00
 */

namespace app\api\controller;

use app\common\lib\Aes;
use app\common\lib\exception\ApiException;
use app\common\lib\IAuth;
use app\common\lib\Time;
use think\Cache;
use think\Config;
use think\Controller;
use think\exception\Handle;

class Common extends  Controller{

    //hader数据放到里面其他类使用的时候很方便
    public $headers = '';

    public  $size = 10;

    public $page = 1;

    public  $from = 0;

    /*初始化方法*/
    public function _initialize()
    {
        $this->checkRequestAuth();
//        $this->testAes();



    }


    /*每次检查请求是不是合法的*/

    public function checkRequestAuth(){
        $headers = request()->header();






            /*sing 加密客户端的工程师 解密 服务端工程师*/

        //校验sign授权码验证

        if(empty($headers['sign'])){
            throw new ApiException('sign不存在',400);
        }

        //如果配置文件里面不存数组里面的设备平台就返回错误
        if(!in_array($headers['app_type'],config('app.apptypes'))){
            throw new ApiException('类型不合法',400);
        }

        if(!IAuth::checkSingPass($headers)){
            throw new ApiException('授权码sign失败',401);
        }

        //(1)存放数据验证唯一性。当客户端APP它发送一个sign的时候我们服务端要做一个判断我们
        //给它一个缓存中做一个标识我们认为它已经使用了，那么它下次在请求我们就判断已经请求过了
        /*1、如果网站是放在一台服务器上面我们推荐用文件的形式
        2、如果是分布式的我们推荐放到mysql中去
        3、如果是多台分布式也可以使用redis看情况 服务器量大的话推荐redis
         *
         * */
        //(2)服务端给我们发送业务逻辑的时候也要加密就是body请求体也要加密
        //放到缓存中去
        /**1、sign参数
         * 2、参数标识1
         * 最后一个参数是失效时间，
         */

        //开启缓存
        Cache::set($headers['sign'],1,config('app.app_sign_cachetime'));




        $this->headers = $headers;



    }
/*这个函数是测试数据不需要*/
    public function  testAes(){

        $data = [

            'did' => '12345',
            'version' =>1,
            'time' => Time::get13TimeStamp()
        ];

        $str = 'goJRQFzQIpi40YE5euhg9N/zIyulv2SzZv7IrGzTw566nuWD2wX7oZWAXAehgq+I
';



    }



    /**
     * @param array $news
     * @return array获取栏目的信息直接返回属于那个栏目
     */

    protected function getDealNews($news=[]){
        if(empty($news)){
            return [];
        }


        $cats = config('cat.lists');


        foreach ($news as $key => $new){
            $news[$key]['catname'] = $cats[$new['catid']] ? $cats[$new['catid']] : '-';
        }



        return $news;
    }



}