<?php
/**
 * Created by PhpStorm.
 * User: Jne
 * Date: 2018/8/16
 * Time: 14:28
 */

namespace app\api\controller\v1;

use app\api\controller\Common;
use app\common\lib\Aes;
use app\common\lib\exception\ApiException;
use app\common\lib\IAuth;
use app\common\lib\Message;
use app\common\lib\Page;
use think\Controller;
use think\exception\Handle;

//点赞 新闻点赞功能开发

class Upvote extends AuthBase {

    public function  save(){


        $id = input('post.id',0,'intval');
        if(empty($id)){
            return show(config('code.error'),'id不存在',[],404);

        }

        //然后我们在判断这个id新闻文章是不是存在不存在我们就不能执行

        $news = model('News')->get(['id'=>$id]);

        if(!$news || $news->status != 1){
            return show(config('code.error'),'没有这条新闻',[],404);

        }




        $data = [

            'user_id' =>$this->user->id,
            'news_id' =>$id,
        ];





        if(empty($data)){
            return show(config('code.error'),'数据不合法',[],404);

        }


        //查询库里面是不是存在了点赞
        $userNews = model('UserNews')->get($data);




        if($userNews){
            return show(config('code.error'),'已经点赞过了',[],404);

        }

        //写入user_news表
        try{
            $userNewsId = model('UserNews')->add($data);
            if($userNewsId){
                model('News')->where(['id'=>$id])->setInc('upvote_count');
                return show(config('code.error'),'点赞成功',[],404);

            }else{
                return show(config('code.success'),'内部错误点赞失败',[],404);

            }

        }catch (\Exception $e){

            return show(config('code.success'),'内部错误点赞失败',[],500);

        }




    }

    //取消点赞

    public function delete(){
        $id = input('delete.id',0,'intval');
        if(empty($id)){
            return show(config('code.error'),'id不存在',[],404);

        }




        $data = [

            'user_id' =>$this->user->id,
            'news_id' =>$id,
        ];


        $userNews = model('UserNews')->get($data);

        if(empty($userNews)){
            return show(config('code.error'),'没有被点赞过',[],404);

        }


        try{

            //查询出来删除点赞关联表
            $userNewsId = model('UserNews')->where($data)->delete();
            if($userNewsId){
                model('News')->where(['id'=>$id])->setDec('upvote_count');
                return show(config('code.error'),'取消点赞成功',[],404);

            }else{
                return show(config('code.success'),'内部错误取消点赞失败',[],404);

            }

        }catch (\Exception $e){

            return show(config('code.success'),'内部错误点赞失败',[],500);

        }


    }

    //查询文章是不是被点赞过
    public function read(){
        $id = input('param.id',0,'intval');
        if(empty($id)){
            return show(config('code.error'),'id不存在',[],404);

        }



        $data = [

            'user_id' =>$this->user->id,
            'news_id' =>$id,
        ];



        $userNews = model('UserNews')->get($data);



        if(!empty($userNews)){
            return show(config('code.success'),'ok',['isUpvote'=>1],404);

        }else{
            return show(config('code.error'),'点赞查询失败',['isUpvote'=>0],404);

        }

    }


}