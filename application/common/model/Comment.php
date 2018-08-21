<?php
/**
 * Created by PhpStorm.
 * User: Jne
 * Date: 2018/8/14
 * Time: 11:08
 */
namespace app\common\model;

use think\Db;

class Comment extends Base{

    //通过条件获取评论的数量
    public function getNormalCommentsCountByCondition($param = []){
        $count = Db::table('ent_comment')
            ->alias(['ent_comment'=>'a','ent_user' => 'b'])
            ->join('ent_user','a.user_id=b.id AND a.news_id='.$param['news_id'])->count();
        //join链接用户表ent_user

        return $count;

    }

    /*通过条件获取列表数据 多表联合查询 评论表和 用户表*/

    public function getNormalCommentByCondition($param = [],$from = 0,$size = 5){

        $result = Db::table('ent_comment')
            ->alias(['ent_comment'=>'a','ent_user' => 'b'])
            ->join('ent_user','a.user_id=b.id AND a.news_id='.$param['news_id'])
            ->limit($from,$size)
            ->order(['a.id'=>'desc'])
            ->select();
        //join链接用户表ent_user

        return $result;
    }


    /*多表查询优化第二个版本*/

    //获取comment评论表的总数量
    public function getCountByCondition($param = []){

        return $this->where($param)
            ->field('id')
            ->count();
    }


    /*获取评论列表页第二个版本查询优化方法*/
    //也需要状态等于一的
    public function getListsByCondition($param = [],$from = 0,$size = 5){


        return $this->where($param)
            ->field('*')
            ->limit($from,$size)
            ->order(['id'=>'desc'])
            ->select();
    }
}