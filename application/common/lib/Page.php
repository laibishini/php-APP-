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

class Page {


    //基类获取自动分页总数和当前页信息如果以后如果谁需要直接调用$this->size $this->page
    public static function getPageAndSize($data){



      $page =  !empty($data['page']) ? $data['page'] : 1;
        $size =  !empty($data['size']) ? $data['size'] : config('paginate.list_rows');

        $from = ($page -1) * $size;

        $page = [
            'page' =>$page,
            'size' =>$size,
            'from' =>$from,


        ];

        return $page;

    }



}