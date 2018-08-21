<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

//分页

function pagination($obj){
    if(!$obj){
        return '';
    }

    $params = request()->param();

    return '<div class="imooc-app">'.$obj->appends($params)->render().'</div>';
}

//获取栏目的分类返回分类名字
function getCatName($catId){
    if(!$catId){
        return '';

    }

    $cats = config('cat.lists');

    return !empty($cats[$catId]) ? $cats[$catId] : '';
}

//返回是否是推荐


function isYesNo($str){
    return $str ? '<span style="color: red">是</span>' : '<span>否</span>' ;
}

/**
 * restful
 * @param int $status 业务的状态码
 * @param  string $message 信息提示
 * @param  int $code httpcode状态码
 * @param  int $data 传过来的数据
 */

function show ($status, $message, $data=[], $httpCode=200){
    $data = [
        'status' =>$status,
        'message' => $message,
        'data' => $data,
    ];

    return json($data,$httpCode);
}