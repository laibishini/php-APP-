<?php
/**
 * Created by PhpStorm.
 * User: Jne
 * Date: 2018/8/16
 * Time: 14:28
 */

namespace app\api\controller\v1;

use app\api\controller\Common;
use think\Controller;

class Cat extends Common {

    /*栏目接口*/
    public  function read(){
        $cats = config('cat.lists');
        $result[] = [
            'catid' => 0,
            'catname' => '首页'
        ];
        foreach ($cats as $catid=>$catname){
            $result[] = [
              'catid' =>$catid,
              'catname' =>$catname
            ];
        }

        return show(config('code.success'),'ok',$result,200);
    }
}