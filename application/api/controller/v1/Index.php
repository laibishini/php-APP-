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
use think\Controller;
use think\exception\Handle;

class Index extends Common {

    /*栏目接口*/
    /*获取首页接口*/
    /*1/头图4-6条内容
    2、推荐位列表*/
    public  function index(){

        $heads = model('News')->getIndexHeadNormalNews();

        $heads= $this->getDealNews($heads);


        $position = model('News')->getPositionNormalNews();

        $heads= $this->getDealNews($position);

        $result = [

            'heads' =>$heads,
            'opsition'=>$position,
        ];

//
        return show(config('code.success'),'ok',$result,200);

    }

    /**
     * 监测版本是不是更新
     */
    public function init(){



        $version = model('Version')->getLastNormalVersionByAppType($this->headers['app_type']);

        if(empty($version)){
            return new ApiException('error',404);
        }


        if($version->version > $this->headers['version']){
            $version->is_update = $version->is_force == 1 ? 2:1;
        }else{
            $version->is_update = 0;
        }

        //记录用户的基本信息用于统计 是内部人员看的 设备号、APP手机类型 版本

        $actives =[
            'version'=>$this->headers['version'],
            'app_type'=>$this->headers['app_type'],
            'did'=>$this->headers['did'],

        ];

       try{
           model('AppActive')->add($actives);
       }catch (\Exception $e){

           //可以写入 Log:write
       }


        return show(config('code.success'),'ok',$version,200);



    }


}