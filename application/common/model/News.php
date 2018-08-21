<?php
/**
 * Created by PhpStorm.
 * User: Jne
 * Date: 2018/8/14
 * Time: 11:08
 */
namespace app\common\model;

class News extends Base{

    //后台自动化分页第一种分页方式
    public function  getNews($data=[]){

        //不不等于-1状态 where status != -1
        $data['status'] = [
          'neq',config('code.status_delete')
        ];
        $order = ['id' => 'desc'];

        $result = $this->where($data)
            ->order($order)
            ->paginate();



        return $result;
    }


    //模式2 第二种分页

    public function getNewsByCondition($condition=[],$from = 0,$size=5){

        //查询状态 不是-1的 0 1
        if(!isset($condition['status'])){
        $condition['status'] = [
            'neq',config('code.status_delete')
        ];

        }

        $order = ['id' => 'desc'];
        //相当于limit a b


        $result = $this->where($condition)
            ->field($this->_getListField())
            ->limit($from,$size)
            ->order($order)
            ->select();


        //返回查询的数据
        return  $result;


    }


    /**
     * @param int $num 获取详情页推荐 5条默认
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */


    public function getRankNormalNews($num=20){
        $data = [

            'status' =>1,

        ];

        $order = [
            'read_count'=>'desc',
        ];



        return $this->where($data)
            ->field($this->_getListField())
            ->order($order)
            ->limit($num)
            ->select();
    }

    //返回查询数据总条数和分页有关
    public  function getNewsCountByCondition($condition=[]){

        //前台只需要1的信息 status = 1的形式
        if(!isset($condition['status'])) {
            $condition['status'] = [
                'neq', config('code.status_delete')
            ];
        }


       return $this->where($condition)->field($this->_getListField())->count();

    }


    public function getIndexHeadNormalNews($num=4){

        $data = [
            'status'=>1,
            'is_head_figure'=>1,
        ];

        $order = [
            'id'=>'desc',
        ];



        return $this->where($data)
            ->field($this->_getListField())
            ->order($order)
            ->limit($num)
            ->select();
    }

    /*获取推荐的数据*/
    public function getPositionNormalNews($num=20){
        $data = [

            'status' =>1,
            'is_position' =>1,
        ];

        $order = [
            'id'=>'desc',
        ];



        return $this->where($data)
            ->field($this->_getListField())
            ->order($order)
            ->limit($num)
            ->select();
    }


    private function _getListField(){
        return [
            'id',
            'catid',
            'image',
            'title',
            'read_count',
            'is_position',
            'status'
        ];
    }

}