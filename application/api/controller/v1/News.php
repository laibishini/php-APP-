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
use app\common\lib\Page;
use think\Controller;

class News extends Common {

    //新闻搜索接口

    //栏目列表页接口

    public  function index(){


        $data = input('get.');



        /*校验validate验证机制做相关校验*/
        $whereData['status'] = config('code.status_normal');

        if(!empty($data['catid'])){
            $whereData['catid'] = input('get.catid',0,'intval');
        }


        if(!empty($data['title'])){
            $whereData['title'] = ['like','%'.$data['title'].'%'];
        }




        $result = Page::getPageAndSize($data);
        $total = model('News')->getNewsCountByCondition($whereData);
        $news = model('News')->getNewsByCondition($whereData,$result['from'],$result['size']);


       $result = [
         'taotal'=>$total,
         'page_num'=> ceil($total /$result['size']),
           'news' =>$this->getDealNews($news),

       ];

       return show(config('code.success'),'ok',$result,200);


    }

    /**
     * @return ApiException|\think\response\Json
     * @throws 新闻详情页
     */
    public function  read(){

        $id = input('param.id',0,'intval');

        if(empty($id)){
            return new ApiException('id is not ',404);
        }

        //然后通过id去获取表单里面的数据
        $news = model('News')->get($id);

        if(empty($news) || $news->status != config('code.status_normal')){

            return ApiException('不存在该新闻',404);

        }

        //自增自减阅读数  直接写setInc这个字段里面的值就可以自动添加阅读数
        try{
            model('News')->where(['id'=>$id])->setInc('read_count');
        }catch (\Exception $e){
            return ApiException('不存在该新闻',404);
        }



        return show(config('code.success'),'ok',$news,200);
    }
}