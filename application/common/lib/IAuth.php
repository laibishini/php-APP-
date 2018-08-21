<?php
/**
 * Created by PhpStorm.
 * User: Jne
 * Date: 2018/8/10
 * Time: 21:46
 *把相关的涉及到功能性的内容放到里面
 *
 */
namespace app\common\lib;

use think\Cache;
use think\Config;
use traits\think\Instance;

class IAuth {

    //设置密码返回字符串


    public static function setPassword($data){

        return md5($data.config('app.password_pre_halt'));
    }

    /**
     * @param $data生成每次请求的sign
     * @return HexString|string
     */
    public static function setSign($data){
        //1、先按照字段排序
        ksort($data);

        //把字符串变成查询字符串a=b&=d
        $string = http_build_query($data);
        //3、通过字符串来进行加密
        $string = (new Aes())->encrypt($string);

        return $string;



    }


    /**
     * 检查sign是不是正常
     * @param string $sing
     * @param $data
     * $data是返回的信息
     */
    public static  function checkSingPass($data){
        //解码加密的sign信息

        $str = (new Aes())->decrypt($data['sign']);


        //如果解码出来的数据是空的直接false
        if(empty($str)){
            return false;
        }

        //didid=xx&app_type=3解码数据变成数组  arr赋值给$arr
        parse_str($str,$arr);

       if(!is_array($arr) || empty($arr['did']) || $arr['did'] != $data['did']){
           return false;
       }

       if(!config('app_debug')){

           //有可能app客户端的时间和我们的服务器的时间不一样有可能大，那么再请求的时候先请求一下时间然后把差值补上在请求就可以保证时间的准确性
       //如果APP发来的时间和我们当前服务器时间相减，然后大于我们本地设置配置文件中的10秒我们就让它不能请求就是说时间已经过期
       if((time()-ceil($arr['time'] /1000)) > config('app.app_sign_time')){
            return false;
        }

        //如果系统中有这个缓存标识，我们就判断它是请求过了返回false
        if(Cache::get($data['sign'])){
            return false;
        }


       }
        //缓存在runtime cache下面

       return true;

    }

    /**
     * 唯一性的 token
     * @param string $phone
     * @return string
     */

    public static function setAppLoginToken($phone =''){
        $str = md5(uniqid(md5(microtime(true)),true));
        $str = sha1($str.$phone);
        return $str;
    }


    //获取缓存数据里面的值手机号的code
    public  static  function checkSmsIdentify($phone= 0){


        if(!$phone ){
            return false;
        }

        return Cache::get($phone);
    }

}