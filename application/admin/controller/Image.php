<?php
namespace app\admin\controller;

use app\common\lib\Upload;
use think\Controller;
use think\Exception;
use think\Request;
use think\Session;
//后太图骗上传逻辑
class Image extends Base
{
    public function upload0() {

        $file = Request::instance()->file('file');
        // 把图片上传到指定的文件夹中
        $info = $file->move('upload');

        if($info && $info->getPathname()) {
            $data = [
                'status' => 1,
                'message' => 'OK',
                'data' => '/'.$info->getPathname(),
            ];
            echo json_encode($data);exit;
        }

        echo json_encode(['status' => 0, 'message' => '上传失败']);

    }

//七牛云存储上传方式
    public function upload(){

        try{
            $image = Upload::image();
        }catch (Exception $e){
            echo json_encode(['status' => 0, 'message' => '上传失败']);
        }


        if($image){


            $data = [
                'status' => 1,
                'message' => 'OK',
                'data' => config('qiniu.image_url').'/'.$image,
            ];
            echo json_encode($data);exit;

        }else{
            echo json_encode(['status' => 0, 'message' => '上传失败']);

        }
    }



}
