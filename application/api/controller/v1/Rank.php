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
use think\Controller;
use think\exception\Handle;

/*相关推荐排行榜*/

class Rank extends Common {

    public  function index(){


        try{
            $rands = model('News')->getRankNormalNews();
            $rands = $this->getDealNews($rands);


        }catch (\Exception $e){

            return new ApiException('error',400);
        }


        return show(config('code.success'),'ok',$rands,200);

    }

}