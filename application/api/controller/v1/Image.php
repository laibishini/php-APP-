<?php
/**
 * Created by PhpStorm.
 * User: Jne
 * Date: 2018/8/16
 * Time: 14:28
 */

namespace app\api\controller\v1;

use app\api\controller\Common;
use app\common\lib\exception\ApiException;
use app\common\lib\Message;
use app\common\lib\Page;
use app\common\lib\Upload;
use think\Controller;
use think\exception\Handle;

/*相关推荐排行榜*/

class Image extends AuthBase {

    public  function save(){

        //在做postman做测试的时候content-type 一定不要传值取消要不接受不到
        $image = Upload::image();

        if($image){
            return show(config('code.success'),'ok',config('qiniu.image_url').'/'.$image,200);

        }


    }


}