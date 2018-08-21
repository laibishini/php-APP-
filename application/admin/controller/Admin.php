<?php

namespace app\admin\controller;

use app\common\lib\IAuth;
use think\Controller;

class Admin extends Controller{

    public function add(){
        //判断是否是post提交
        if(request()->isPost()){
            //打印数据
           $data =  input('post.');
            //校验机制//实例化我们创建的公共校验类库
            //halt($validate->check($data));这个halt也可以走测试带自动终止功能die;
            $validate = validate('AdminUser');
            if(!$validate->check($data)){
                //如果不是这个验证规则提示信息用户名密码不能超过20
                $this->error($validate->getError());
            }

            $data['password'] = IAuth::setPassword($data['password']);
            //状态正常
            $data['status'] = 1;
            //监测数据异常
            try{
               $id =  model('AdminUser')->add($data);
            }catch (\Exception $e){
                //打印异常
                $this->error( $e->getMessage());
            }

            if($id){
                $this->success('id = '.$id.'用户新增成功');
            }else{
                $this->error('用户添加失败');
            }

            //写入数据库

        }else{
            return $this->fetch();
        }

    }
}