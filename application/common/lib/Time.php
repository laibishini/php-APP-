<?php
/**
 * Created by PhpStorm.
 * User: Jne
 * Date: 2018/8/15
 * Time: 23:03
 */

namespace app\common\lib;


class Time{
    /*获取13位的时间戳*/

    public static function get13TimeStamp(){
        //用空来分割
        list($t1,$t2)=explode(' ',microtime());

        return $t2.ceil($t1*1000);
    }
}