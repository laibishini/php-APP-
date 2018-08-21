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
use think\helper\Hash;

//评论接口

class Comment extends AuthBase {


//新闻评论
    public function  save(){

        //获取传过来的数据
        $data = input('post.',[]);



        //验证validate

        $data['user_id'] = $this->user->id;

        try{
            $userNewsId = model('Comment')->add($data);
            if($userNewsId){

                return show(config('code.error'),'ok',[],404);

            }else{
                return show(config('code.success'),'评论失败',[],404);

            }

        }catch (\Exception $e){

            return show(config('code.success'),'内部错误评论失败',[],500);

        }




    }


    //获取评论数量、列表 这个是关联数据表查询 第一个版本多表方式影响性能

//    public function read(){
//
//        //1
//        $newsId = input('param.id',0,'intval');
//
//        if(empty($newsId)){
//            return show(config('code.error'),'id is not',[],404);
//
//        }
//
//        //2
//        $param = ['news_id'=>$newsId];
//
//        $page = Page::getPageAndSize(input('param.'));
//
//
//        //3//获取评论的数量
//       $count = model('Comment')->getNormalCommentsCountByCondition($param);
//
//       //获取评论全部内容
//       $comment = model('Comment')->getNormalCommentByCondition($param,$page['from'],$page['size']);
//       //获取页码
//
//
//
//       //4返回数据
//
//        $result = [
//            'taotal'=>$count,
//            'page_num'=> ceil($count /$page['size']),
//            'list' =>$comment,
//
//        ];
//
//        return show(config('code.success'),'ok',$result);
//
//
//    }



/*第二个版本*/

    public function  read(){


        $newsId = input('param.id',0,'intval');
        if(empty($newsId)){
            return show(config('code.error'),'id is not',[],404);

        }

        $param = ['news_id'=>$newsId];

        //获取评论列表总数
        $count = model('Comment')->getCountByCondition($param);

        //获取页码
        $page = Page::getPageAndSize(input('param.'));


        //查询评论表获取news_id = 8 比如 查询它是一个数组或者是对象 结果就一条评论
        $comments = model('Comment')->getListsByCondition($param,$page['from'],$page['size']);


        //这步是获取user_id 和to_user_id目标用户评论
        if($comments){
            foreach ($comments as $comment){

                $userIds[] = $comment['user_id'];

                if($comment['to_user_id']){
                    $userIds[] =$comment['to_user_id'];
                }
            }

            //去重复的评论表 user_id to_user_id 一个是用户ID 和目标的评论的ID都要查出来 //array (size=2)
            //  0 => int 1
            //  1 => int 3
            $userIds = array_unique($userIds);






            // 用户表查出来以后是两个用户对象 1和3用户
            $userIds = model('User')->getUsersUserId($userIds);



            if(empty($userIds)){

            }else{
                foreach ($userIds as $userId){

                  //0=>1 1=>3这两个对象数组
                    $userIdNames[$userId->id] = $userId;


                    //[1] = user1用户 [3] = user3用户
                }
            }


            //把评论内容组合起来和用户的信息组装
            $resultDatas = [];
             //循环评论表查出来的数据
            foreach ($comments as $comment){
                $resultDatas[] =[
                  'id'=>$comment->user_id,
                    'user_id'=>$comment->to_user_id,
                    'to_user_id'=>$comment->to_user_id,
                    'content'=>$comment->content,
                    'username'=>!empty($userIdNames[$comment->user_id])? $userIdNames[$comment->user_id]->username :'',
                    'tousername'=>!empty($userIdNames[$comment->to_user_id])? $userIdNames[$comment->to_user_id]->username :'',
                    'parent_id'=>$comment->parent_id,
                    'create_time'=>$comment->create_time,
                    'image'=>!empty($userIdNames[$comment->to_user_id])? $userIdNames[$comment->to_user_id]->image :'',
                ];
            }



        $result = [
            'taotal'=>$count,
            'page_num'=> ceil($count /$page['size']),
            'list' =>$resultDatas,

        ];

        return show(config('code.success'),'ok',$result);



        }
    }
}