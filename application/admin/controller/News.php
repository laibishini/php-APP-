<?php
namespace app\admin\controller;

use app\api\controller\Common;
use app\common\lib\Page;
use think\Controller;
use think\Exception;
use think\Model;
use think\Session;

class News extends Base
{
    public function index(){
        //get post 以及一些其他的相关的数据
        $data = input('param.');

        //下一页也要查询
        $query = http_build_query($data);







        //转换查询条件
        $whereData = [];

        if(!empty($data['start_time']) && !empty($data['end_time'])
        && $data['end_time'] > $data['start_time'])
        {
            //查询条件创建时间
            $whereData['create_time'] = [

                ['gt',strtotime($data['start_time'])],
                ['lt',strtotime($data['end_time'])],


            ];

        }

        //如果栏目的id不为空就查询它
        if(!empty($data['catid'])){
            $whereData['catid'] = intval($data['catid']);
        }

        if(!empty($data['title'])){
            $whereData['title'] = ['like','%'.$data['title'].'$'];
        }

        //模式一显示分页
//       $news =  model('News')->getNews();

        //获取数据


        //2、模式2显示分页 首先我们要获要显示page size from limit from size

       $result = Page::getPageAndSize($data);






        //获取表里面的数据
        $news = model('News')->getNewsByCondition($whereData,$result['from'],$result['size']);

        //要查询出总的页数总数 有多少页
        $total = model('News')->getNewsCountByCondition();



        $pageTotal = ceil($total/$result['size']);//向上取整1.1页就成为了2页




        //把手机到的表单数据传递给显示器

        return $this->fetch('',[
            'news' =>$news,
            'cats' => config('cat.lists'),
            'pageTotal'=>$pageTotal,
            'curr' =>$result['page'],
            'start_time' => empty($data['start_time']) ? '':$data['start_time'],
            'end_time' => empty($data['end_time']) ? '':$data['end_time'],
            'catid' => empty($data['catid']) ? '': $data['catid'],
            'title' => empty($data['title']) ? '' : $data['title'],
            'query' => $query,

        ]);
    }
    public function add()
    {

        //1、先判断它是用什么提交的
        if(request()->isPost()){
            //传过来数据先要监测数据的合法性先不写validae

            $data = input('post.');


            //实例化模型对象写如数据
            try{
                //插入成功返回主键的值

                $id = model('News')->add($data);

            }catch (\Exception $e){

                return $this->result('',0,'新增失败');
            }

            if($id){

                return $this->result(['jump_url'=>url('news/index')],1,'ok');
            }else{
                return $this->result('',0,'新增失败');
            }




        }else{
            //默认加载模版
            return $this->fetch('',[
                'cats' => config('cat.lists')
            ]);
        }




    }




}
