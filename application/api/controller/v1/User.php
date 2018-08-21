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

//这个是用户登录成功了 然后跳转到个人中心

/*获取用户信息*/

class User extends AuthBase {
    /**
     * 用户信息非常敏感所以我们加密进行传输
     * 获取用户的基本信息 如果登录成功了就要跳转到个人中心，所以我们要获取个人的数据信息我们继承了所以用户登录就保存了登录信息。
     */
    public  function read(){


        $obj = new Aes();

        return show(config('code.success'),'ok',$obj->encrypt($this->user),200);



    }


        /*获取了登录用户信息显示了个人中心里面，如果用户要该我们就应该让他修改用户信息*/

    public function update(){
        $postDate = input('param.');


        $data = [];
        if(!empty($postDate['password'])){

            //这个严格意义上来说也是需要用AES前端进行加密我们在去解密然后写如数据库
            //如果用户名不为空，并且我们要查询数据是不是存在如果不存在在执行下面的条件，如果存在就不执行了。
            $data['password'] = IAuth::setPassword($postDate['password']);
        }
        //如果传过来的图片不为空
        if(!empty($postDate['image'])){
            $data['image'] = $postDate['image'];
        }
        if(!empty($postDate['username'])){

            //如果用户名不为空，并且我们要查询数据是不是存在如果不存在在执行下面的条件，如果存在就不执行了。
            $data['username'] = $postDate['username'];
        }
        if(!empty($postDate['sex'])){
            $data['sex'] = $postDate['sex'];
        }
        if(!empty($postDate['signature'])){
            $data['signature'] = $postDate['signature'];
        }

        if(empty($data)){
            return show(config('code.error'),'数据不合法',[],404);

        }



        try{

           $id =  model("User")->save($data,['id'=>$this->user->id]);
           if($id){
               return show(config('code.error'),'修改数据成功',[],404);

           }else{
               return show(config('code.success'),'修改数据失败',[],404);

           }
        }catch (\Exception $e){
            return show(config('code.error'),$e->getMessage(),[],404);

        }
    }

}